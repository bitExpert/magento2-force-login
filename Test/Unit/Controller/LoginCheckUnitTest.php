<?php

/*
 * This file is part of the Magento2 Force Login Module package.
 *
 * (c) bitExpert AG
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace bitExpert\ForceCustomerLogin\Test\Unit\Controller;

/**
 * Class LoginCheckUnitTest
 * @package bitExpert\ForceCustomerLogin\Test\Unit\Controller
 */
class LoginCheckUnitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function testClassExists()
    {
        $this->assertTrue(class_exists('\bitExpert\ForceCustomerLogin\Controller\LoginCheck'));
    }

    /**
     * @test
     * @depends testClassExists
     */
    public function testConstructor()
    {
        $loginCheck = new \bitExpert\ForceCustomerLogin\Controller\LoginCheck(
            $this->getContext(),
            $this->getDeploymentConfig(),
            $this->getWhitelistRepository(),
            ''
        );

        // check if mandatory interfaces are implemented
        $classInterfaces = class_implements($loginCheck);
        $this->assertContains('bitExpert\ForceCustomerLogin\Api\Controller\LoginCheckInterface', $classInterfaces);
    }

    /**
     * Run test with data listed on the whitelist, so no redirecting is forced.
     * @test
     * @depends testConstructor
     */
    public function testPositiveWhitelistedUrlMapping()
    {
        $urlRule = '/foobar';

        // simple
        $this->runCase('http://example.tld/shopview/foobar/baz', $urlRule);
        // with shopview prefix
        $this->runCase('http://example.tld/foobar/baz', $urlRule);
    }

    /**
     * Run test with data listed on the whitelist as wildcard, so no redirecting is forced.
     * @test
     * @depends testConstructor
     */
    public function testPositiveWhitelistedUrlMappingWithWildcardRule()
    {
        // --- Empty
        $emptyUrlRule = '';
        // simple
        $this->runCase('http://example.tld/shopview/foobar/baz', $emptyUrlRule);
        // with shopview prefix
        $this->runCase('http://example.tld/foobar/baz', $emptyUrlRule);

        // --- Wildcard
        $wildcardUrlRule = '.*';
        // simple
        $this->runCase('http://example.tld/shopview/foobar/baz', $wildcardUrlRule);
        // with shopview prefix
        $this->runCase('http://example.tld/foobar/baz', $wildcardUrlRule);

        // --- Wildcard
        $wildcardUrlRule = '/.*';
        // simple
        $this->runCase('http://example.tld/shopview/foobar/baz', $wildcardUrlRule);
        // with shopview prefix
        $this->runCase('http://example.tld/foobar/baz', $wildcardUrlRule);
    }

    /**
     * Run test with data not listed on the whitelist, so redirecting is forced.
     * @test
     * @depends testConstructor
     */
    public function testNegativeWhitelistedUrlMapping()
    {
        $urlRule = '/barfoo';

        // simple
        $this->runCase('http://example.tld/foobar/baz', $urlRule, true);
        // with shopview prefix
        $this->runCase('http://example.tld/shopview/foobar/baz', $urlRule, true);
    }

    /**
     * Run test with data not listed on the whitelist, so redirecting is forced.
     * @test
     * @depends testConstructor
     */
    public function testNoUrlMappingOnMatchingPathWithTargetUrl()
    {
        $urlString = 'http://example.tld/customer/account/login';
        $targetUrl = '/customer/account/login';

        // --- Context
        $url = $this->getUrl();
        $url->expects($this->once())
            ->method('getCurrentUrl')
            ->will($this->returnValue($urlString));

        $response = $this->getResponse();
        $redirect = $this->getRedirect();

        $response->expects($this->never())
            ->method('sendResponse');

        $redirect->expects($this->never())
            ->method('redirect')
            ->with($response, $targetUrl);

        $context = $this->getContext();
        $context->expects($this->exactly(1))
            ->method('getUrl')
            ->will($this->returnValue($url));
        $context->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue($response));
        $context->expects($this->once())
            ->method('getRedirect')
            ->will($this->returnValue($redirect));

        $loginCheck = new \bitExpert\ForceCustomerLogin\Controller\LoginCheck(
            $context,
            $this->getDeploymentConfig(),
            $this->getWhitelistRepository(),
            $targetUrl
        );

        $loginCheck->execute();
    }

    /**
     * @param string $urlString
     * @param string $urlRule
     * @param bool $runMapping
     */
    protected function runCase($urlString, $urlRule, $runMapping = false)
    {
        $targetUrl = '/customer/account/login';

        // --- Context
        $url = $this->getUrl();
        $url->expects($this->once())
            ->method('getCurrentUrl')
            ->will($this->returnValue($urlString));

        $response = $this->getResponse();
        $redirect = $this->getRedirect();

        if (!$runMapping) {
            $response->expects($this->never())
                ->method('sendResponse');

            $redirect->expects($this->never())
                ->method('redirect')
                ->with($response, $targetUrl);
        } else {
            $response->expects($this->once())
                ->method('sendResponse');

            $redirect->expects($this->once())
                ->method('redirect')
                ->with($response, $targetUrl);
        }

        $context = $this->getContext();
        $context->expects($this->exactly(1))
            ->method('getUrl')
            ->will($this->returnValue($url));
        $context->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue($response));
        $context->expects($this->once())
            ->method('getRedirect')
            ->will($this->returnValue($redirect));

        // --- Whitelist Entries
        $whitelistEntityOne = $this->getMockBuilder('\bitExpert\ForceCustomerLogin\Model\WhitelistEntry')
            ->disableOriginalConstructor()
            ->getMock();
        $whitelistEntityOne->expects($this->once())
            ->method('getUrlRule')
            ->will($this->returnValue($urlRule));
        $whitelistCollection = $this
            ->getMockBuilder('\bitExpert\ForceCustomerLogin\Model\ResourceModel\WhitelistEntry\Collection')
            ->disableOriginalConstructor()
            ->getMock();
        $whitelistCollection->expects($this->once())
            ->method('getItems')
            ->will($this->returnValue([$whitelistEntityOne]));
        $whitelistRepository = $this->getWhitelistRepository();
        $whitelistRepository->expects($this->once())
            ->method('getCollection')
            ->will($this->returnValue($whitelistCollection));

        // --- Deployment configuration
        $deploymentConfig = $this->getDeploymentConfig();
        $deploymentConfig->expects($this->once())
            ->method('get')
            ->with(\Magento\Backend\Setup\ConfigOptionsList::CONFIG_PATH_BACKEND_FRONTNAME)
            ->will($this->returnValue('admin'));

        $loginCheck = new \bitExpert\ForceCustomerLogin\Controller\LoginCheck(
            $context,
            $deploymentConfig,
            $whitelistRepository,
            $targetUrl
        );

        $loginCheck->execute();
    }

    /**
     * @return \Magento\Framework\App\Action\Context
     */
    protected function getContext()
    {
        return $this->getMockBuilder('\Magento\Framework\App\Action\Context')->disableOriginalConstructor()->getMock();
    }

    /**
     * @return \Magento\Framework\UrlInterface
     */
    protected function getUrl()
    {
        return $this->createMock('\Magento\Framework\UrlInterface');
    }

    /**
     * @return \Magento\Framework\App\Response\RedirectInterface
     */
    protected function getRedirect()
    {
        return $this->createMock('\Magento\Framework\App\Response\RedirectInterface');
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface
     */
    protected function getResponse()
    {
        return $this->createMock('\Magento\Framework\App\ResponseInterface');
    }

    /**
     * @return \Magento\Framework\App\DeploymentConfig
     */
    protected function getDeploymentConfig()
    {
        return $this->getMockBuilder('\Magento\Framework\App\DeploymentConfig')
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @return \bitExpert\ForceCustomerLogin\Api\Repository\WhitelistRepositoryInterface
     */
    protected function getWhitelistRepository()
    {
        return $this->createMock('\bitExpert\ForceCustomerLogin\Api\Repository\WhitelistRepositoryInterface');
    }
}
