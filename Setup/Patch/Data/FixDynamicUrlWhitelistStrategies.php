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

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

/**
 * Switches the default whitelist entries that were installed with the static strategy to the
 * regex-all strategy. The static strategy requires an exact path match, so it never matches URLs
 * with dynamic path segments (ESI block and handle parameters, store switcher parameters) or a
 * store code prefix (e.g. /nl/customer/account/createpost).
 *
 * Only entries that are still exactly as installed by default are updated, so whitelist entries
 * that have been customized in any way are left untouched.
 */
class FixDynamicUrlWhitelistStrategies implements DataPatchInterface
{
    public const TABLE = 'bitexpert_forcelogin_whitelist';

    /**
     * Default entries to fix: url rule => label as installed by default
     */
    public const ENTRIES = [
        '/page_cache/block/esi/blocks' => 'Varnish ESI url',
        '/stores/store/redirect' => 'Store-Switcher Redirect',
        '/stores/store/switch' => 'Store-Switcher Switch',
        '/customer/account/resetpasswordpost' => 'Customer Account Reset Password Post',
        '/customer/account/createpost' => 'Customer Create (Post)',
        '/paypal/ipn/' => 'Paypal',
    ];

    public const OLD_STRATEGY = 'default';
    public const NEW_STRATEGY = 'regex-all';

    /**
     * @var ModuleDataSetupInterface
     */
    private ModuleDataSetupInterface $moduleDataSetup;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     */
    public function __construct(ModuleDataSetupInterface $moduleDataSetup)
    {
        $this->moduleDataSetup = $moduleDataSetup;
    }

    /**
     * @inheritdoc
     */
    public function apply()
    {
        $connection = $this->moduleDataSetup->getConnection();
        $connection->startSetup();

        $table = $this->moduleDataSetup->getTable(self::TABLE);
        foreach (self::ENTRIES as $urlRule => $label) {
            $connection->update(
                $table,
                ['strategy' => self::NEW_STRATEGY],
                [
                    'url_rule = ?' => $urlRule,
                    'label = ?' => $label,
                    'strategy = ?' => self::OLD_STRATEGY,
                    'store_id = ?' => 0,
                    'editable = ?' => 1,
                ]
            );
        }

        $connection->endSetup();

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
        return [
            Patch501::class,
        ];
    }
}
