<?php

/*
 * This file is part of the Magento2 Force Login Module package.
 *
 * (c) bitExpert AG
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace bitExpert\ForceCustomerLogin\Repository;

use \bitExpert\ForceCustomerLogin\Api\Data\WhitelistEntryFactoryInterface;
use \bitExpert\ForceCustomerLogin\Api\Data\Collection\WhitelistEntryCollectionFactoryInterface;
use \bitExpert\ForceCustomerLogin\Model\WhitelistEntrySearchResultInterfaceFactory as SearchResultFactory;
use \Magento\Store\Model\StoreManager;

/**
 * Class WhitelistRepository
 * @package bitExpert\ForceCustomerLogin\Model
 */
class WhitelistRepository implements \bitExpert\ForceCustomerLogin\Api\Repository\WhitelistRepositoryInterface
{
    /**
     * Special store ids
     */
    const ROOT_STORE_ID = 0;

    /**
     * @var WhitelistEntryFactoryInterface
     */
    protected $entityFactory;
    /**
     * @var WhitelistEntryCollectionFactoryInterface
     */
    protected $collectionFactory;
    /**
     * @var SearchResultFactory
     */
    protected $searchResultFactory;
    /**
     * @var StoreManager
     */
    protected $storeManager;

    /**
     * WhitelistRepository constructor.
     * @param WhitelistEntryFactoryInterface $entityFactory
     * @param WhitelistEntryCollectionFactoryInterface $collectionFactory
     * @param StoreManager $storeManager
     * @param SearchResultFactory $searchResultFactory
     */
    public function __construct(
        WhitelistEntryFactoryInterface $entityFactory,
        WhitelistEntryCollectionFactoryInterface $collectionFactory,
        StoreManager $storeManager,
        SearchResultFactory $searchResultFactory
    ) {
        $this->entityFactory = $entityFactory;
        $this->collectionFactory = $collectionFactory;
        $this->storeManager = $storeManager;
        $this->searchResultFactory = $searchResultFactory;
    }

    /**
     * {@inheritDoc}
     */
    public function createEntry($entityId, $label, $urlRule, $storeId = 0)
    {
        $whitelist = $this->entityFactory->create();

        if (null !== $entityId) {
            $whitelist = $whitelist->load($entityId);
        }

        if (!$whitelist->getId()) {
            $whitelist = $this->entityFactory->create()->load($label, 'label');
        }

        // check if existing whitelist entry is editable
        if ($whitelist->getId() &&
            !$whitelist->getEditable()) {
            throw new \RuntimeException(
                'Whitelist entry not editable.'
            );
        }

        $whitelist->setLabel($label);
        $whitelist->setUrlRule($urlRule);
        $whitelist->setStoreId($storeId);
        $whitelist->setEditable(true);

        $validator = new \bitExpert\ForceCustomerLogin\Validator\WhitelistEntry();
        $validator->validate($whitelist);

        $whitelist->save();

        return $whitelist;
    }

    /**
     * {@inheritDoc}
     */
    public function deleteEntry($id)
    {
        $whitelist = $this->entityFactory->create()->load($id);
        if (!$whitelist->getId() ||
            !$whitelist->getEditable()) {
            return false;
        }

        $whitelist->delete();

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function getCollection()
    {
        $currentStore = $this->storeManager->getStore();

        $collection = $this->collectionFactory->create();

        $collection->addFieldToFilter(
            'store_id',
            [
                'in' => [
                    static::ROOT_STORE_ID,
                    (int) $currentStore->getId()
                ]
            ]
        );

        return $collection->load();
    }

    /**
     * {@inheritDoc}
     */
    public function getList(\Magento\Framework\Api\SearchCriteria $searchCriteria)
    {
        /** @var \bitExpert\ForceCustomerLogin\Api\Data\Collection\WhitelistEntrySearchResultInterface $searchResult */
        $searchResult = $this->searchResultFactory->create();
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ? $filter->getConditionType() : 'eq';
                $searchResult->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }
        $searchResult->setCurPage($searchCriteria->getCurrentPage());
        $searchResult->setPageSize($searchCriteria->getPageSize());

        return $searchResult;
    }
}
