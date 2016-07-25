<?php

/*
 * This file is part of the Magento2 Force Login Module package.
 *
 * (c) bitExpert AG
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace bitExpert\ForceCustomerLogin\Block\Adminhtml;

/**
 * Class Whitelist
 * @package bitExpert\ForceCustomerLogin\Block\Adminhtml
 * @codingStandardsIgnoreFile
 */
class Whitelist extends \Magento\Backend\Block\Widget\Container
{
    /**
     * {@inheritDoc}
     */
    protected function _prepareLayout()
    {
        $addButtonProps = [
            'id' => 'add_new_entry',
            'label' => __('Add Entry'),
            'class' => 'primary add',
            'button_class' => '',
            'onclick' => "setLocation('" . $this->getCreateUrl() . "')",
            'class_name' => 'Magento\Backend\Block\Widget\Button'
        ];
        $this->buttonList->add('add_new', $addButtonProps);

        return parent::_prepareLayout();
    }

    /**
     * Retrieve create url
     *
     * @return string
     */
    protected function getCreateUrl()
    {
        return $this->getUrl(
            'ForceCustomerLogin/Whitelist/Create'
        );
    }
}
