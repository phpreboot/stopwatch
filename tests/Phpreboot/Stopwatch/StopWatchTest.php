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

use Phpreboot\Stopwatch\StopWatch;
use Phpreboot\Stopwatch\Watch;

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
        /** @var Watch $defaultWatch */
        $defaultWatch = $this->stopWatch->getWatch();

        $this->assertNotNull($defaultWatch, "No watch available");
        $this->assertInstanceOf('Phpreboot\Stopwatch\Watch', $defaultWatch, "Not an instance of Watch");

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
        $this->assertInstanceOf('Phpreboot\Stopwatch\Watch', $watch, "Default watch is not an instance of Watch.");
        $this->assertEquals(StopWatch::STOPWATCH_DEFAULT_NAME, $watch->getName(), "Name of default was was not correctly set.");
    }

    /**
     * @group Phpreboot_Stopwatch_StopWatch_getWatch
     */
    public function testWatchCouldBeReturned()
    {
        $this->stopWatch->addWatch('newWatch');

        $newWatch = $this->stopWatch->getWatch("newWatch");
        $this->assertInstanceOf('Phpreboot\Stopwatch\Watch', $newWatch, "New watch is not an instance of Watch.");
    }
}