<?php

/*
 * This file is part of the Magento2 Force Login Module package.
 *
 * (c) bitExpert AG
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace bitExpert\ForceCustomerLogin\Block\Adminhtml\Whitelist;

/**
 * Class Create
 * @package bitExpert\ForceCustomerLogin\Block\Adminhtml\Whitelist
 * @codingStandardsIgnoreFile
 */
class Create extends \Magento\Backend\Block\Widget\Form\Container
{
    /**
     * @var string
     */
    protected $formIdentifier = 'create_whitelist_entry_form';

    /**
     * Initialize printer post create block
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId = 'whitelist_entry_id';
        $this->_blockGroup = 'BitExpert_ForceCustomerLogin';
        $this->_controller = 'adminhtml_whitelist';
        $this->_mode = 'create';

        parent::_construct();

        $this->updateButtonControls();
    }

    /**
     * @return string
     */
    protected function getFormIdentifier()
    {
        return $this->formIdentifier;
    }

    /**
     * {@inheritDoc}
     */
    protected function _buildFormClassName()
    {
        return \lcfirst(parent::_buildFormClassName());
    }

    /**
     * {@inheritdoc}
     */
    public function getSaveUrl()
    {
        return $this->getUrl(
            'ForceCustomerLogin/Whitelist/Save',
            [
                $this->_objectId => $this->getRequest()->getParam($this->_objectId)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBackUrl()
    {
        return $this->getUrl('ForceCustomerLogin/Whitelist');
    }

    /**
     */
    protected function updateButtonControls()
    {
        $this->buttonList->update(
            'save',
            'data_attribute',
            [
                'mage-init' => [
                    'button' => [
                        'event' => 'save',
                        'target' => '#' . $this->getFormIdentifier()
                    ]
                ],
            ]
        );
    }
}