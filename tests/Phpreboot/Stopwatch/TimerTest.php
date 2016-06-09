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

use Phpreboot\Stopwatch\Timer;

/**
 * Class TimerTest
 * @package Phpunit\Stopwatch
 * @group Phpreboot
 * @group Phpreboot_Stopwatch
 * @group Phpreboot_Stopwatch_Timer
 */
class TimerTest  extends \PHPUnit_Framework_TestCase
{
    private $name = "MyTimer";
    /** @var Timer */
    private $timer;

    public function setUp()
    {
        $this->timer = new Timer($this->name);
    }

    public function tearDown()
    {
        $this->timer = null;
    }

    /**
     * @group Phpreboot_Stopwatch_Timer_constructor
     */
    public function testTimerInitializeCorrectly()
    {
        $this->assertSame($this->name, $this->timer->getName(), "Timer doesn't initialized with correct name.");
        $this->assertSame(Timer::STATE_NOT_STARTED, $this->timer->getState(), "Timer doesn't initialized with correct state.");
        $this->assertSame(0, $this->timer->getTime(), "Timer doesn't initialize with correct time.");
    }

    /**
     * @group Phpreboot_Stopwatch_Timer_getTime
     */
    public function testGetTimeReturnsTime()
    {
        $this->assertSame(0, $this->timer->getTime(), "getTime not returned 0 a initial time.");

        $this->timer->start();
        $this->assertGreaterThan(0, $this->timer->getTime(), "getTime not returning increased time");
    }

    /**
     * @group Phpreboot_Stopwatch_Timer_stop
     */
    public function testNewTimerCanNotBeStopped()
    {
        $this->assertFalse($this->timer->stop(), "stop() on new timer returns true.");
    }

    /**
     * @group Phpreboot_Stopwatch_Timer_stop
     */
    public function testPausedTimerCanBeStopped()
    {
        $this->timer->start();
        $this->timeWaster();
        $this->timer->pause();
        $this->assertTrue($this->timer->stop(), 'Paused timer could not be stopped.');
    }

    /**
     * @group Phpreboot_Stopwatch_Timer_stop
     */
    public function testStartedTimerCanBeStopped()
    {
        $this->timer->start();
        $this->timeWaster();
        $this->assertTrue($this->timer->stop(), 'Started timer could not be stopped.');
    }

    /**
     * @group Phpreboot_Stopwatch_Timer_pause
     */
    public function testStartedTimerCanBePaused()
    {
        $this->timer->start();
        $this->timeWaster();
        $this->assertTrue($this->timer->pause(), "Started timer could not be paused.");
        $this->assertSame(Timer::STATE_PAUSED, $this->timer->getState(), "'pause()' on started watch do not set correct state.");
    }

    /**
     * @group Phpreboot_Stopwatch_Timer_pause
     */
    public function testPausedTimerCanNotBePaused()
    {
        $this->timer->start();
        $this->timeWaster();
        $this->timer->pause();
        $this->assertFalse($this->timer->pause(), "Paused timer was paused again.");
    }

    /**
     * @group Phpreboot_Stopwatch_Timer_pause
     */
    public function testNotStartedTimerCanNotBePaused()
    {
        $this->assertFalse($this->timer->pause(), "Paused timer was paused again.");
    }

    /**
     * @group Phpreboot_Stopwatch_Timer_pause
     */
    public function testStoppedTimerCanNotBePaused()
    {
        $this->timer->start();
        $this->timeWaster();
        $this->timer->stop();
        $this->assertFalse($this->timer->pause(), "Paused timer was paused again.");
    }

    /**
     * @group Phpreboot_Stopwatch_Timer_start
     */
    public function testTimerCanBeStarted()
    {
        $this->assertTrue($this->timer->start(), "Timer 'start' didn't returned true");
        $this->assertSame(Timer::STATE_STARTED, $this->timer->getState(), "Timer could not be started correctly.");
    }

    /**
     * @group Phpreboot_Stopwatch_Timer_start
     */
    public function testStartedTimerCanNotBeStarted()
    {
        $this->timer->start();
        $this->assertFalse($this->timer->start(), "'start' on already started timer returned true.");
    }

    /**
     * @group Phpreboot_Stopwatch_Timer_start
     */
    public function testStoppedTimerCanNotBeStarted()
    {
        $this->timer->start();
        $this->timeWaster();
        $this->timer->stop();
        $this->assertFalse($this->timer->start(), "'start' on stopped timer returned true.");
        $this->assertSame(Timer::STATE_STOPPED, $this->timer->getState(), 'Stopped timer was started again.');
    }

    protected function timeWaster()
    {
        // Wasting some time
        for ($i = 0; $i < 100; $i++) {
            $a = $i;
        }
    }
}