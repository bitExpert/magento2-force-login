<?php

/*
 * This file is part of the Force Login module for Magento2.
 *
 * (c) bitExpert AG
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BitExpert\ForceCustomerLogin\Model;

use BitExpert\ForceCustomerLogin\Api\Repository\WhitelistRepositoryInterface;
use BitExpert\ForceCustomerLogin\Model\WhitelistDefaultPool;

/**
 * Class WhitelistEntryDefaultInstaller
 *
 * @package BitExpert\ForceCustomerLogin\Model
 * @codingStandardsIgnoreFile
 */
class WhitelistDefaultInstaller
{
    private WhitelistDefaultPool $whitelistDefaultPool;
    private WhitelistRepositoryInterface $whitelistRepository;

    /**
     * Installer constructor
     */
    public function __construct(
        WhitelistDefaultPool $whitelistDefaultPool,
        WhitelistRepositoryInterface $whitelistRepository,
    ) {
        $this->whitelistDefaultPool = $whitelistDefaultPool;
        $this->whitelistRepository = $whitelistRepository;
    }

    public function install(): void
    {
        foreach ($this->whitelistDefaultPool->getEntries() as $route => $data) {
            try {
                $this->whitelistRepository->createEntry(
                    null,
                    $data['label'],
                    $route,
                    $data['strategy'] ?: 'default',
                );
            } catch (\Exception $e) {
                // log here
            }
        }
    }
}
