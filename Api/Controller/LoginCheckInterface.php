<?php

/*
 * This file is part of the Force Login module for Magento2.
 *
 * (c) bitExpert AG
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BitExpert\ForceCustomerLogin\Api\Controller;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\ResponseInterface;

/**
 * Interface LoginCheckInterface
 *
 * @package BitExpert\ForceCustomerLogin\Api\Controller
 */
interface LoginCheckInterface
{
    /*
     * Configuration
     */
    const MODULE_CONFIG_TARGET = 'customer/BitExpert_ForceCustomerLogin/url';

    /*
     * `Redirect Customer to Account Dashboard after Logging in` config path
     */
    const CONFIG_PATH_REDIRECT_TO_CUSTOMER_DASHBOARD = 'customer/startup/redirect_dashboard';

    /*
     * Configuration
     */
    const MODULE_CONFIG_FORCE_SECURE_REDIRECT = 'customer/BitExpert_ForceCustomerLogin/force_secure_redirect';

    /**
     * Manages redirect
     *
     * @return bool TRUE if redirection is applied, else FALSE
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute();
}
