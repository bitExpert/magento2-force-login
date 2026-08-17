<?php

/*
 * This file is part of the Force Login module for Magento2.
 *
 * (c) bitExpert AG
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BitExpert\ForceCustomerLogin\Api\Data\Collection;

/**
 * Interface WhitelistEntrySearchResultInterface
 *
 * @package BitExpert\ForceCustomerLogin\Api\Data\Collection
 */
interface WhitelistEntrySearchResultInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get items.
     *
     * @return \BitExpert\ForceCustomerLogin\Api\Data\WhitelistEntryInterface[] Array of collection items.
     */
    public function getItems();

    /**
     * Set items.
     *
     * @param \BitExpert\ForceCustomerLogin\Api\Data\WhitelistEntryInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
