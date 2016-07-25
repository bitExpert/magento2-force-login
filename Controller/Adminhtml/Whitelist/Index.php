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

/**
 * Class Index
 * @package bitExpert\ForceCustomerLogin\Controller\Adminhtml\Whitelist
 * @codingStandardsIgnoreFile
 */
class Index extends \Magento\Backend\App\Action
{
    /**
     * Index Action*
     * @return void
     */
    public function execute()
    {
        $this->_view->loadLayout();
        $this->_view->renderLayout();
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('bitExpert_ForceCustomerLogin::bitexpert_force_customer_login_manage');
    }
}