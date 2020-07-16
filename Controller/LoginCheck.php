<?php

/*
 * This file is part of the Force Login module for Magento2.
 *
 * (c) bitExpert AG
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BitExpert\ForceCustomerLogin\Controller;

use BitExpert\ForceCustomerLogin\Api\Controller\LoginCheckInterface;
use BitExpert\ForceCustomerLogin\Api\Repository\WhitelistRepositoryInterface;
use BitExpert\ForceCustomerLogin\Helper\Strategy\StrategyManager;
use BitExpert\ForceCustomerLogin\Model\Session;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Response\Http as ResponseHttp;
use Magento\Framework\App\ResponseInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class LoginCheck
 *
 * @package BitExpert\ForceCustomerLogin\Controller
 */
class LoginCheck implements LoginCheckInterface
{
    /**
     * @var CustomerSession
     */
    private $customerSession;
    /**
     * @var Session
     */
    private $session;
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;
    /**
     * @var WhitelistRepositoryInterface
     */
    private $whitelistRepository;
    /**
     * @var StrategyManager
     */
    private $strategyManager;
    /**
     * @var ModuleCheck
     */
    private $moduleCheck;
    /**
     * @var \Magento\Framework\UrlInterface
     */
    private $url;
    /**
     * @var RequestInterface
     */
    private $request;
    /**
     * @var ResponseHttp
     */
    private $response;
    /**
     * @var PasswordResetHelper
     */
    private $passwordResetHelper;

    /**
     * Creates a new {@link \BitExpert\ForceCustomerLogin\Controller\LoginCheck}.
     *
     * @param Context $context
     * @param CustomerSession $customerSession
     * @param Session $session
     * @param StoreManagerInterface $storeManager
     * @param ScopeConfigInterface $scopeConfig
     * @param WhitelistRepositoryInterface $whitelistRepository
     * @param StrategyManager $strategyManager
     * @param ModuleCheck $moduleCheck
     * @param ResponseHttp $response
     * @param PasswordResetHelper $passwordResetHelper
     */
    public function __construct(
        Context $context,
        CustomerSession $customerSession,
        Session $session,
        StoreManagerInterface $storeManager,
        ScopeConfigInterface $scopeConfig,
        WhitelistRepositoryInterface $whitelistRepository,
        StrategyManager $strategyManager,
        ModuleCheck $moduleCheck,
        ResponseHttp $response,
        PasswordResetHelper $passwordResetHelper
    ) {
        $this->customerSession = $customerSession;
        $this->session = $session;
        $this->storeManager = $storeManager;
        $this->scopeConfig = $scopeConfig;
        $this->whitelistRepository = $whitelistRepository;
        $this->strategyManager = $strategyManager;
        $this->moduleCheck = $moduleCheck;
        $this->response = $response;
        $this->passwordResetHelper = $passwordResetHelper;
        $this->request = $context->getRequest();
        $this->url = $context->getUrl();
    }

    /**
     * Manages redirect
     *
     * @return bool TRUE if redirection is applied, else FALSE
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute()
    {
        if ($this->moduleCheck->isModuleEnabled() === false) {
            return false;
        }

        // if user is logged in, every thing is fine
        if ($this->customerSession instanceof \Magento\Customer\Model\Session &&
            $this->customerSession->isLoggedIn()) {
            return false;
        }

        $url = $this->url->getCurrentUrl();
        $urlParts = \parse_url($url);
        $path = is_array($urlParts) && isset($urlParts['path']) ? $urlParts['path'] : '';
        $targetUrl = $this->getTargetUrl();

        // current path is already pointing to target url, no redirect needed
        if (strpos($path, $targetUrl)!== false) {
            return false;
        }

        // Explicit behaviour for password reset creation
        if ($this->passwordResetHelper->processDirectCreatePasswordRequest($this->url, $this->request)) {
            return false;
        }

        //Get the customer account URL if `Redirect Customer to Account Dashboard after Logging in` is enabled
        if ($this->isRedirectToCustomerDashBoardEnabled()) {
            $url = $this->url->getRouteUrl('customer/account/');
        }
        
        // Set Url To redirect ,using standard method of magento
        $this->customerSession->setBeforeAuthUrl($url);

        // check if current url is a match with one of the ignored urls
        /** @var \BitExpert\ForceCustomerLogin\Model\WhitelistEntry $rule */
        foreach ($this->whitelistRepository->getCollection()->getItems() as $rule) {
            $strategy = $rule->getStrategy();
            if(!$strategy) {
                return false;
            }
            $strategy = $this->strategyManager->get($strategy);
            if ($strategy->isMatch($path, $rule)) {
                return false;
            }
        }

        // Add any GET query parameters back to the path after making our url checks.
        if(is_array($urlParts) && isset($urlParts['query']) && !empty($urlParts['query'])) {
            $path .= '?' . $urlParts['query'];
        }

        if (!$this->isAjaxRequest()) {
            $this->session->setAfterLoginReferer($path);
        }

        $this->response->setNoCacheHeaders();
        $this->response->setRedirect($this->getRedirectUrl($targetUrl));
        $this->response->sendResponse();
        return true;
    }

    /**
     * @return string
     */
    private function getTargetUrl()
    {
        return $this->scopeConfig->getValue(
            self::MODULE_CONFIG_TARGET,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return bool
     */
    private function getForceSecureRedirectOption()
    {
        return (bool) $this->scopeConfig->getValue(
            self::MODULE_CONFIG_FORCE_SECURE_REDIRECT,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function getBaseUrl()
    {
        $secure = $this->getForceSecureRedirectOption();
        $secure = ($secure === true) ? true : null;
        return $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_WEB, $secure);
    }

    /**
     * Check if a request is AJAX request
     *
     * @return bool
     */
    private function isAjaxRequest()
    {
        if ($this->request instanceof \Magento\Framework\App\Request\Http) {
            return $this->request->isAjax();
        }
        if ($this->request->getParam('ajax') || $this->request->getParam('isAjax')) {
            return true;
        }
        return false;
    }

    /**
     * @param string $targetUrl
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function getRedirectUrl($targetUrl)
    {
        return \sprintf(
            '%s%s',
            $this->getBaseUrl(),
            $targetUrl
        );
    }

    /**
     * @return bool
     */
    private function isRedirectToCustomerDashBoardEnabled()
    {
        return (bool) $this->scopeConfig->isSetFlag(
            self::CONFIG_PATH_REDIRECT_TO_CUSTOMER_DASHBOARD,
            ScopeInterface::SCOPE_WEBSITES
        );
    }
}
