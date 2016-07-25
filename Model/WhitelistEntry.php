<?php

/*
 * This file is part of the Magento2 Force Login Module package.
 *
 * (c) bitExpert AG
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace bitExpert\ForceCustomerLogin\Model;

/**
 * Class WhitelistEntry
 * @package bitExpert\ForceCustomerLogin\Model
 * @codingStandardsIgnoreFile
 */
class WhitelistEntry extends \Magento\Framework\Model\AbstractModel implements
    \bitExpert\ForceCustomerLogin\Api\Data\WhitelistEntryInterface
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('bitExpert\ForceCustomerLogin\Model\ResourceModel\WhitelistEntry');
    }

    /**
     * {@inheritdoc}
     */
    public function getStoreId()
    {
        return (int) $this->getData(static::KEY_STORE_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setStoreId($storeId)
    {
        return $this->setData(static::KEY_STORE_ID, $storeId);
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return $this->getData(static::KEY_LABEL);
    }

    /**
     * {@inheritdoc}
     */
    public function setLabel($label)
    {
        return $this->setData(static::KEY_LABEL, $label);
    }

    /**
     * {@inheritdoc}
     */
    public function getUrlRule()
    {
        return $this->getData(static::KEY_URL_RULE);
    }

    /**
     * {@inheritdoc}
     */
    public function setUrlRule($urlRule)
    {
        return $this->setData(static::KEY_URL_RULE, $urlRule);
    }

    /**
     * {@inheritdoc}
     */
    public function getEditable()
    {
        return !!$this->getData(static::KEY_EDITABLE);
    }

    /**
     * {@inheritdoc}
     */
    public function setEditable($editable)
    {
        return $this->setData(static::KEY_EDITABLE, $editable);
    }
}
