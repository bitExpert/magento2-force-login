<?php

/*
 * This file is part of the Force Login module for Magento2.
 *
 * (c) bitExpert AG
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BitExpert\ForceCustomerLogin\Setup\Patch\Data;

use BitExpert\ForceCustomerLogin\Api\Repository\WhitelistRepositoryInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class Patch541 implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private ModuleDataSetupInterface $moduleDataSetup;

    /**
     * @var WhitelistRepositoryInterface
     */
    private WhitelistRepositoryInterface $whitelistRepository;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        WhitelistRepositoryInterface $whitelistRepository
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->whitelistRepository = $whitelistRepository;
    }

    /**
     * @inheritdoc
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        try {
            $this->whitelistRepository->createEntry(
                null,
                'Shipping Tracking Popup',
                '/shipping/tracking/popup',
                'default',
            );
        } catch (\Exception $e) {
            // entry already exists, continue
        }

        $this->moduleDataSetup->getConnection()->endSetup();

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public static function getDependencies()
    {
        return [];
    }
}
