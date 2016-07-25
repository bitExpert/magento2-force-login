<?php

/*
 * This file is part of the Magento2 Force Login Module package.
 *
 * (c) bitExpert AG
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace bitExpert\ForceCustomerLogin\Model\ResourceModel\WhitelistEntry;

/**
 * Class Collection
 * @package bitExpert\ForceCustomerLogin\Model\ResourceModel\WhitelistEntry
 * @codingStandardsIgnoreFile
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'whitelist_entry_id';

    /**
     * {@inheritDoc}
     */
    protected function _construct()
    {
        $this->_init(
            'bitExpert\ForceCustomerLogin\Model\WhitelistEntry',
            'bitExpert\ForceCustomerLogin\Model\ResourceModel\WhitelistEntry'
        );
    }
}
