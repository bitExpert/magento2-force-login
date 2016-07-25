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
 * Interface WhitelistEntrySearchResultInterface
 * @package bitExpert\ForceCustomerLogin\Api\Data\Collection
 */
interface WhitelistEntrySearchResultInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get items.
     *
     * @return \bitExpert\ForceCustomerLogin\Api\Data\WhitelistEntryInterface[] Array of collection items.
     */
    public function getItems();

    /**
     * Set items.
     *
     * @param \bitExpert\ForceCustomerLogin\Api\Data\WhitelistEntryInterface[] $items
     * @return $this
     */
    public function setItems(array $items = null);
}
