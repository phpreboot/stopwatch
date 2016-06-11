<?php

/*
 * This file is part of the PHPReboot/Stopwatch package.
 *
 * (c) Kapil Sharma <kapil@phpreboot.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phpunit\Stopwatch;

use phpDocumentor\Reflection\Types\This;
use Phpreboot\Stopwatch\StopWatch;
use Phpreboot\Stopwatch\Timer;

/**
 * Class StopWatchTest
 * @package Phpunit\Stopwatch
 * @group Phpreboot
 * @group Phpreboot_Stopwatch
 * @group Phpreboot_Stopwatch_StopWatch
 */
class StopWatchTest extends \PHPUnit_Framework_TestCase
{
    /** @var  StopWatch $stopWatch */
    private $stopWatch;

    public function setUp()
    {
        $this->stopWatch = new StopWatch();
    }

    public function tearDown()
    {
        $this->stopWatch = null;
    }

    /* ******************/
    /* Constructor test */
    /* ******************/
    /**
     * @group Phpreboot_Stopwatch_StopWatch_constructor
     */
    public function testStopWatchHaveDefaultWatch()
    {
        /** @var Timer $defaultWatch */
        $defaultWatch = $this->stopWatch->getWatch();

        $this->assertNotNull($defaultWatch, "No watch available");
        $this->assertInstanceOf('Phpreboot\Stopwatch\Timer', $defaultWatch, "Not an instance of Watch");

        $name = $defaultWatch->getName();

        $this->assertEquals(StopWatch::STOPWATCH_DEFAULT_NAME, $name, "Default name of StopWatch is not set correctly");
    }

    /* ***************/
    /* addWatch Test */
    /* ***************/
    /**
     * @group Phpreboot_Stopwatch_StopWatch_addWatch
     */
    public function testWatchCanBeAdded()
    {
        $this->assertEquals(1, $this->stopWatch->getWatchCount(), "Stopwatch doesn't initialized with default watch.");

        $this->stopWatch->addWatch('testWatch');
        $this->assertEquals(2, $this->stopWatch->getWatchCount(), "Stopwatch could not be added");
    }

    /**
     * @group Phpreboot_Stopwatch_StopWatch_addWatch
     */
    public function testWatchCanNotBeAddedWithDuplicateName()
    {
        $this->assertEquals(1, $this->stopWatch->getWatchCount(), "Stopwatch doesn't initialized with default watch.");
        $this->assertFalse($this->stopWatch->addWatch(StopWatch::STOPWATCH_DEFAULT_NAME), "Watch with default name was duplicated.");
        $this->assertEquals(1, $this->stopWatch->getWatchCount(), "Watch with default name was duplicated.");

        $this->assertTrue($this->stopWatch->addWatch('testWatch'), "New watch couldn't be added.");
        $this->assertEquals(2, $this->stopWatch->getWatchCount(), "New watch couldn't be added.");
        $this->assertFalse($this->stopWatch->addWatch('testWatch'), "New watch with duplicate name was added.");
        $this->assertEquals(2, $this->stopWatch->getWatchCount(), "New watch with duplicate name was added.");
    }

    /**
     * @group Phpreboot_Stopwatch_StopWatch_addWatches
     */
    public function testMultipleWatchesCanBeAdded()
    {
        $this->assertEquals(1, $this->stopWatch->getWatchCount(), "Stopwatch doesn't initialized with default watch.");

        $this->assertSame(array(true,true),
            $this->stopWatch->addWatches(array('watch1', 'watch2')),
            "addWatches returns false for two new watches.");
        $this->assertEquals(3, $this->stopWatch->getWatchCount(), "Stopwatch doesn't initialized with default watch.");
    }

    /**
     * @group Phpreboot_Stopwatch_StopWatch_addWatches
     */
    public function testAddWatchesWithEmptyArrayReturnsFalse()
    {
        $this->assertSame(array(), $this->stopWatch->addWatches(array()), "addWatches with empty array returns true.");
    }

    /**
     * @group Phpreboot_Stopwatch_StopWatch_addWatches
     */
    public function testAddWatchesWithDuplicateNamesReturnsCorrectStatus()
    {
        $this->assertSame(array(true, false),
            $this->stopWatch->addWatches(array('name', 'name')),
            "addWatches with duplicate name do not returns correct message.");
    }

    /* ********************/
    /* getWatchCount Test */
    /* ********************/
    /**
     * @group Phpreboot_Stopwatch_StopWatch_getWatchCount
     */
    public function testWatchCountIsCorrect()
    {
        $totalWatch = $this->stopWatch->getWatchCount();

        $this->assertEquals(1, $totalWatch, "Watch count is not correct");
    }

    /* ***************/
    /* getWatch Test */
    /* ***************/
    /**
     * @group Phpreboot_Stopwatch_StopWatch_getWatch
     */
    public function testDefaultWatchCouldBeReturned()
    {
        $watch = $this->stopWatch->getWatch();
        $this->assertInstanceOf('Phpreboot\Stopwatch\Timer', $watch, "Default watch is not an instance of Watch.");
        $this->assertEquals(StopWatch::STOPWATCH_DEFAULT_NAME, $watch->getName(), "Name of default was was not correctly set.");
    }

    /**
     * @group Phpreboot_Stopwatch_StopWatch_getWatch
     */
    public function testWatchCouldBeReturned()
    {
        $this->stopWatch->addWatch('newWatch');

        $newWatch = $this->stopWatch->getWatch("newWatch");
        $this->assertInstanceOf('Phpreboot\Stopwatch\Timer', $newWatch, "New watch is not an instance of Watch.");
    }

    /**
     * @group Phpreboot_Stopwatch_StopWatch_getWatch
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Watch NonExistingWatch does not exist.
     */
    public function testGetWatchForNonExistingWatchThrowsException()
    {
        $this->stopWatch->getWatch('NonExistingWatch');
    }

    /**
     * @group Phpreboot_Stopwatch_StopWatch_isWatchExist
     */
    public function testWatchExistenceCanBeChecked()
    {
        $this->assertFalse($this->stopWatch->isWatchExist('newWatch'));
        $this->stopWatch->addWatch("newWatch");
        $this->assertTrue($this->stopWatch->isWatchExist('newWatch'));
    }

    /**
     * @group Phpreboot_Stopwatch_StopWatch_start
     */
    public function testStopWatchCanBeStarted()
    {
        $this->assertSame(Timer::STATE_NOT_STARTED, $this->stopWatch->getWatch()->getState(), "StopWatch timer state is not correct.");
        $this->assertTrue($this->stopWatch->start(), "StopWatch could not be started");
        $this->assertSame(Timer::STATE_STARTED, $this->stopWatch->getWatch()->getState(), "StopWatch timer state is not correct after start.");
    }

    /**
     * @group Phpreboot_Stopwatch_StopWatch_start
     */
    public function testNonExistingStopWatchCanNotBeStarted()
    {
        $this->assertFalse($this->stopWatch->start('nonExistingWatch'));
    }

    /**
     * @group Phpreboot_Stopwatch_StopWatch_pause
     */
    public function testStopWatchCanBePaused()
    {
        $this->assertSame(Timer::STATE_NOT_STARTED, $this->stopWatch->getWatch()->getState(), "StopWatch timer state is not correct.");
        $this->assertTrue($this->stopWatch->start(), "StopWatch could not be started");
        $this->assertSame(Timer::STATE_STARTED, $this->stopWatch->getWatch()->getState(), "StopWatch timer state is not correct after start.");
        $this->assertTrue($this->stopWatch->pause(), "StopWatch could not be paused");
        $this->assertSame(Timer::STATE_PAUSED, $this->stopWatch->getWatch()->getState(), "StopWatch timer state is not correct after pause.");
    }

    /**
     * @group Phpreboot_Stopwatch_StopWatch_pause
     */
    public function testNonExistingStopWatchCanNotBePaused()
    {
        $this->assertFalse($this->stopWatch->pause('nonExistingWatch'));
    }

    /**
     * @group Phpreboot_Stopwatch_StopWatch_stop
     */
    public function testStopWatchCanBeStopped()
    {
        $this->assertSame(Timer::STATE_NOT_STARTED, $this->stopWatch->getWatch()->getState(), "StopWatch timer state is not correct.");
        $this->assertTrue($this->stopWatch->start(), "StopWatch could not be started");
        $this->assertSame(Timer::STATE_STARTED, $this->stopWatch->getWatch()->getState(), "StopWatch timer state is not correct after start.");
        $this->assertTrue($this->stopWatch->stop(), "StopWatch could not be stopped");
        $this->assertSame(Timer::STATE_STOPPED, $this->stopWatch->getWatch()->getState(), "StopWatch timer state is not correct after stop.");
    }

    /**
     * @group Phpreboot_Stopwatch_StopWatch_stop
     */
    public function testNonExistingStopWatchCanNotBeStopped()
    {
        $this->assertFalse($this->stopWatch->stop('nonExistingWatch'));
    }
}