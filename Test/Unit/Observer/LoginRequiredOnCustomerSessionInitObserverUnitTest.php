<?php

/*
 * This file is part of the Magento2 Force Login Module package.
 *
 * (c) bitExpert AG
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace bitExpert\ForceCustomerLogin\Test\Unit\Observer;

/**
 * Class LoginRequiredOnCustomerSessionInitObserverUnitTest
 * @package bitExpert\ForceCustomerLogin\Test\Unit\Observer
 * @codingStandardsIgnoreFile
 */
class LoginRequiredOnCustomerSessionInitObserverUnitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function testClassExists()
    {
        $this->assertTrue(class_exists('\bitExpert\ForceCustomerLogin\Observer\LoginRequiredOnCustomerSessionInitObserver'));
    }

    /**
     * @test
     * @depends testClassExists
     */
    public function testConstructor()
    {
        $loginCheck = new \bitExpert\ForceCustomerLogin\Observer\LoginRequiredOnCustomerSessionInitObserver(
            $this->getLoginCheck()
        );

        // check if mandatory interfaces are implemented
        $classInterfaces = class_implements($loginCheck);
        $this->assertContains('bitExpert\ForceCustomerLogin\Api\Observer\LoginRequiredObserverInterface', $classInterfaces);
    }

    /**
     * Check if LoginController is run if the current visitor is not logged in
     * @test
     * @depends testConstructor
     */
    public function testLoginControllerExecutionIfNoCustomerIsLoggedIn()
    {
        $session = $this->getSession();
        $session->expects($this->once())
            ->method('isLoggedIn')
            ->will($this->returnValue(false));

        $event = $this->getEvent();
        $event->expects($this->once())
            ->method('getData')
            ->with('customer_session')
            ->will($this->returnValue($session));

        $observer = $this->getObserver();
        $observer->expects($this->once())
            ->method('getEvent')
            ->will($this->returnValue($event));

        $loginCheckController = $this->getLoginCheck();
        $loginCheckController->expects($this->once())
            ->method('execute');

        $loginCheck = new \bitExpert\ForceCustomerLogin\Observer\LoginRequiredOnCustomerSessionInitObserver(
            $loginCheckController
        );
        $loginCheck->execute($observer);
    }

    /**
     * Check if LoginController is run if the current visitor is not logged in and customer session does not exist
     * @test
     * @depends testConstructor
     */
    public function testLoginControllerExecutionIfCustomerSessionIsNull()
    {
        $event = $this->getEvent();
        $event->expects($this->once())
            ->method('getData')
            ->with('customer_session')
            ->will($this->returnValue(null));

        $observer = $this->getObserver();
        $observer->expects($this->once())
            ->method('getEvent')
            ->will($this->returnValue($event));

        $loginCheckController = $this->getLoginCheck();
        $loginCheckController->expects($this->once())
            ->method('execute');

        $loginCheck = new \bitExpert\ForceCustomerLogin\Observer\LoginRequiredOnCustomerSessionInitObserver(
            $loginCheckController
        );
        $loginCheck->execute($observer);
    }

    /**
     * Check if LoginController is not run if the customer is logged in
     * @test
     * @depends testConstructor
     */
    public function testLoginControllerOmitIfCustomerIsLoggedIn()
    {
        $session = $this->getSession();
        $session->expects($this->once())
            ->method('isLoggedIn')
            ->will($this->returnValue(true));

        $event = $this->getEvent();
        $event->expects($this->once())
            ->method('getData')
            ->with('customer_session')
            ->will($this->returnValue($session));

        $observer = $this->getObserver();
        $observer->expects($this->once())
            ->method('getEvent')
            ->will($this->returnValue($event));

        $loginCheckController = $this->getLoginCheck();
        $loginCheckController->expects($this->never())
            ->method('execute');

        $loginCheck = new \bitExpert\ForceCustomerLogin\Observer\LoginRequiredOnCustomerSessionInitObserver(
            $loginCheckController
        );
        $loginCheck->execute($observer);
    }

    /**
     * @return \Magento\Framework\Event\Observer
     */
    protected function getObserver()
    {
        return $this->getMockBuilder('\Magento\Framework\Event\Observer')->disableOriginalConstructor()->getMock();
    }

    /**
     * @return \Magento\Framework\Event
     */
    protected function getEvent()
    {
        return $this->getMockBuilder('\Magento\Framework\Event')->disableOriginalConstructor()->getMock();
    }

    /**
     * @return \Magento\Customer\Model\Session
     */
    protected function getSession()
    {
        return $this->getMockBuilder('\Magento\Customer\Model\Session')->disableOriginalConstructor()->getMock();
    }

    /**
     * @return \bitExpert\ForceCustomerLogin\Api\Controller\LoginCheckInterface
     */
    protected function getLoginCheck()
    {
        return $this->createMock('\bitExpert\ForceCustomerLogin\Api\Controller\LoginCheckInterface');
    }
}
