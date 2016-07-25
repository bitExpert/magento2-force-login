<?php

/*
 * This file is part of the Magento2 Force Login Module package.
 *
 * (c) bitExpert AG
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace bitExpert\ForceCustomerLogin\Controller\Adminhtml\Whitelist;

use \bitExpert\ForceCustomerLogin\Api\Repository\WhitelistRepositoryInterface;
use \Magento\Framework\Controller\Result\RedirectFactory;
use \Magento\Framework\App\Action\Context;
use \Magento\Framework\Message\ManagerInterface;
use \bitExpert\ForceCustomerLogin\Api\Data\WhitelistEntryFactoryInterface;

/**
 * Class Save
 * @package bitExpert\ForceCustomerLogin\Controller\Adminhtml\Whitelist
 * @codingStandardsIgnoreFile
 */
class Save extends \Magento\Framework\App\Action\Action
{
    /**
     * @var WhitelistEntryFactoryInterface
     */
    protected $whitelistEntityFactory;
    /**
     * @var WhitelistRepositoryInterface
     */
    protected $whitelistRepository;
    /**
     * @var RedirectFactory
     */
    protected $redirectFactory;
    /**
     * @var Context
     */
    protected $context;
    /**
     * @var ManagerInterface
     */
    protected $messageManager;

    /**
     * Save constructor.
     * @param WhitelistEntryFactoryInterface $whitelistEntityFactory
     * @param WhitelistRepositoryInterface $whitelistRepository
     * @param Context $context
     */
    public function __construct(
        WhitelistEntryFactoryInterface $whitelistEntityFactory,
        WhitelistRepositoryInterface $whitelistRepository,
        Context $context
    ) {
        $this->whitelistEntityFactory = $whitelistEntityFactory;
        $this->whitelistRepository = $whitelistRepository;
        $this->redirectFactory = $context->getResultRedirectFactory();
        $this->messageManager = $context->getMessageManager();
        $this->context = $context;
        parent::__construct($context);
    }

    /**
     * Save action.
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $result = $this->redirectFactory->create();

        try {
            $whitelistEntry = $this->whitelistRepository->createEntry(
                $this->getRequest()->getParam('whitelist_entry_id'),
                $this->getRequest()->getParam('label'),
                $this->getRequest()->getParam('url_rule'),
                $this->getRequest()->getParam('store_id', 0)
            );

            if (!$whitelistEntry->getId() ||
                !$whitelistEntry->getEditable()) {
                throw new \RuntimeException(
                    __('Could not persist whitelist entry.')
                );
            }
            $this->messageManager->addSuccess(
                __('Whitelist entry successfully saved.')
            );

            $result->setHttpResponseCode(200);
            $result->setPath('ForceCustomerLogin/Whitelist/index');
        } catch (\Exception $e) {
            $result->setHttpResponseCode(\Magento\Framework\Webapi\Exception::HTTP_INTERNAL_ERROR);
            $this->messageManager->addError(
                \sprintf(
                    __('Could not add record: %s'),
                    $e->getMessage()
                )
            );

            $result->setPath(
                'ForceCustomerLogin/Whitelist/Create',
                [
                    'label' => \base64_encode($this->getRequest()->getParam('label')),
                    'url_rule' => \base64_encode($this->getRequest()->getParam('url_rule')),
                    'store_id' => \base64_encode($this->getRequest()->getParam('store_id', 0))
            ]);
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('bitExpert_ForceCustomerLogin::bitexpert_force_customer_login_manage');
    }
}
