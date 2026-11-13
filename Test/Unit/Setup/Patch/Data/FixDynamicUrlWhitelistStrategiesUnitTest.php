<?php

/*
 * This file is part of the Force Login module for Magento2.
 *
 * (c) bitExpert AG
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BitExpert\ForceCustomerLogin\Test\Unit\Setup\Patch\Data;

use BitExpert\ForceCustomerLogin\Setup\Patch\Data\FixDynamicUrlWhitelistStrategies;
use BitExpert\ForceCustomerLogin\Setup\Patch\Data\Patch501;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class FixDynamicUrlWhitelistStrategiesUnitTest
 *
 * @package BitExpert\ForceCustomerLogin\Test\Unit\Setup\Patch\Data
 */
class FixDynamicUrlWhitelistStrategiesUnitTest extends TestCase
{
    private const EXPECTED_ENTRIES = [
        '/page_cache/block/esi/blocks' => 'Varnish ESI url',
        '/stores/store/redirect' => 'Store-Switcher Redirect',
        '/stores/store/switch' => 'Store-Switcher Switch',
        '/customer/account/resetpasswordpost' => 'Customer Account Reset Password Post',
        '/customer/account/createpost' => 'Customer Create (Post)',
        '/paypal/ipn/' => 'Paypal',
    ];

    /**
     * @test
     */
    public function updatesOnlyUntouchedDefaultEntriesPerRule()
    {
        $connection = $this->createMock(AdapterInterface::class);
        $connection->expects($this->once())->method('startSetup');
        $connection->expects($this->once())->method('endSetup');

        $updates = [];
        $connection->expects($this->exactly(count(self::EXPECTED_ENTRIES)))
            ->method('update')
            ->willReturnCallback(function ($table, array $bind, array $where) use (&$updates) {
                $updates[] = [$table, $bind, $where];
                return 1;
            });

        $setup = $this->createMock(ModuleDataSetupInterface::class);
        $setup->method('getConnection')->willReturn($connection);
        $setup->method('getTable')
            ->with('bitexpert_forcelogin_whitelist')
            ->willReturn('prefix_bitexpert_forcelogin_whitelist');

        $patch = new FixDynamicUrlWhitelistStrategies($setup);
        $this->assertSame($patch, $patch->apply());

        $expected = [];
        foreach (self::EXPECTED_ENTRIES as $urlRule => $label) {
            $expected[] = [
                'prefix_bitexpert_forcelogin_whitelist',
                ['strategy' => 'regex-all'],
                [
                    'url_rule = ?' => $urlRule,
                    'label = ?' => $label,
                    'strategy = ?' => 'default',
                    'store_id = ?' => 0,
                    'editable = ?' => 1,
                ],
            ];
        }
        $this->assertSame($expected, $updates);
    }

    /**
     * Guards against the patch and the default pool in etc/di.xml drifting apart: every entry the
     * patch fixes must be a default entry with the same label that is now installed as regex-all.
     *
     * @test
     */
    public function patchedEntriesMatchDefaultPool()
    {
        $dom = new \DOMDocument();
        $dom->load(__DIR__ . '/../../../../../etc/di.xml');
        $xpath = new \DOMXPath($dom);

        $defaults = [];
        $query = '//type[@name="BitExpert\ForceCustomerLogin\Model\WhitelistDefaultPool"]'
            . '/arguments/argument[@name="entries"]/item';
        foreach ($xpath->query($query) as $item) {
            $defaults[$item->getAttribute('name')] = [
                'label' => $xpath->evaluate('string(item[@name="label"])', $item),
                'strategy' => $xpath->evaluate('string(item[@name="strategy"])', $item),
            ];
        }

        foreach (FixDynamicUrlWhitelistStrategies::ENTRIES as $urlRule => $label) {
            $this->assertArrayHasKey($urlRule, $defaults);
            $this->assertSame(['label' => $label, 'strategy' => 'regex-all'], $defaults[$urlRule]);
        }
    }

    /**
     * @test
     */
    public function runsAfterDefaultWhitelistInstall()
    {
        $this->assertSame([Patch501::class], FixDynamicUrlWhitelistStrategies::getDependencies());
        $patch = new FixDynamicUrlWhitelistStrategies($this->createMock(ModuleDataSetupInterface::class));
        $this->assertSame([], $patch->getAliases());
    }
}
