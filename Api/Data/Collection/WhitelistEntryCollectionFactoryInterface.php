<?php

/*
 * This file is part of the Magento2 Force Login Module package.
 *
 * (c) bitExpert AG
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace bitExpert\ForceCustomerLogin\Api\Data\Collection;

/**
 * Interface WhitelistEntryCollectionFactoryInterface
 * @package bitExpert\ForceCustomerLogin\Api\Data\Collection
 */
interface WhitelistEntryCollectionFactoryInterface
{
    /**
     * Create class instance with specified parameters
     *
     * @param array $data
     * @return \bitExpert\ForceCustomerLogin\Model\ResourceModel\WhitelistEntry\Collection
     */
    public function create(array $data = array());
}
