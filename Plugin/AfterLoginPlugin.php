<?php

/*
 * This file is part of the Force Login module for Magento2.
 *
 * (c) bitExpert AG
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BitExpert\ForceCustomerLogin\Plugin;

use BitExpert\ForceCustomerLogin\Model\Session;
use Magento\Customer\Controller\Account\LoginPost;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;

/**
 * Class AfterLoginPlugin
 *
 * @package BitExpert\ForceCustomerLogin\Plugin
 */
class AfterLoginPlugin
{
    /*
     * Redirect behaviour
     */
    const REDIRECT_DASHBOARD_ENABLED = '1';
    const REDIRECT_DASHBOARD_DISABLED = '0';
    /*
     * Configuration
     */
    const REDIRECT_DASHBOARD_CONFIG = 'customer/startup/redirect_dashboard';
    /**
     * @var Session
     */
    private $session;
    /**
     * @var string
     */
    private $defaultTargetUrl;
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * AfterLoginPlugin constructor.
     *
     * @param Session $session
     * @param ScopeConfigInterface $scopeConfig
     * @param string $defaultTargetUrl
     */
    public function __construct(
        Session $session,
        ScopeConfigInterface $scopeConfig,
        $defaultTargetUrl
    ) {
        $this->session = $session;
        $this->scopeConfig = $scopeConfig;
        $this->defaultTargetUrl = $defaultTargetUrl;
    }

    /**
     * Customer login form page
     *
     * @param LoginPost $customerAccountLoginController
     * @param ResultInterface $resultRedirect
     * @return ResultInterface
     */
    public function afterExecute(LoginPost $customerAccountLoginController, ResultInterface $resultRedirect)
    {
        if (self::REDIRECT_DASHBOARD_ENABLED ===
            $this->scopeConfig->getValue(self::REDIRECT_DASHBOARD_CONFIG)) {
            return $resultRedirect;
        }

        $targetUrl = $this->session->getAfterLoginReferer();
        if (empty($targetUrl)) {
            $targetUrl = $this->defaultTargetUrl;
        }

        /** @var Redirect $resultRedirect */
        if ($resultRedirect instanceof Redirect) {
            $resultRedirect->setUrl($targetUrl);
        }

        return $resultRedirect;
    }
}
