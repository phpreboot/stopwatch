<?php

/*
 * This file is part of the PHPReboot/Stopwatch package.
 *
 * (c) Kapil Sharma <kapil@phpreboot.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phpreboot\Stopwatch;


class Watch
{
    const STATE_NOT_STARTED = 0;
    const STATE_STARTED     = 1;
    const STATE_PAUSED      = 2;
    const STATE_STOPPED     = 3;

    private $name;
    private $state;
    private $startTime;
    private $runtime;

    /**
     * Constructor
     *
     * @param string $name Name of new watch
     */
    public function __construct($name)
    {
        $this->name = $name;
        $this->state = self::STATE_NOT_STARTED;
        $this->runtime = 0;
    }

    public function getTime()
    {
        $currentRunTime = 0;

        if ($this->state === self::STATE_STARTED) {
            $time = microtime(true);
            $currentRunTime = $time - $this->startTime;
        }

        return $this->runtime + $currentRunTime;
    }

    public function stop()
    {
        if ($this->state === self::STATE_STARTED) {
            $this->pause();
        }

        if ($this->state === self::STATE_PAUSED) {
            $this->state = self::STATE_STOPPED;
            return true;
        }

        return false;
    }

    /**
     * Pause the watch.
     *
     * @return bool is watch paused successfully?
     */
    public function pause()
    {
        if ($this->state !== self::STATE_STARTED) {
            return false;
        }

        $time = microtime(true);

        $this->runtime += ($time - $this->startTime);
        $this->startTime = null;
        $this->setState(self::STATE_PAUSED);

        return true;
    }

    /**
     * Start the watch.
     *
     * @return bool returns if watch is started or not.
     */
    public function start()
    {
        if (!$this->canStart()) {
            return false;
        }

        $this->startTime = microtime(true);

        //TODO: Although no chance of validation error, we must set start time to 'null' in case of validation error.
        return $this->setState(self::STATE_STARTED);
    }

    /**
     * Confirms if the watch can be started or not. A watch can be started if it is in following states:
     *   - Not started and
     *   - paused
     * Watch can not be started if it is already running or stopped.
     *
     * @return bool true if we can start the watch, false otherwise.
     */
    public function canStart()
    {
        if ($this->state === self::STATE_NOT_STARTED) {
            return true;
        }

        if ($this->state === self::STATE_PAUSED) {
            return true;
        }

        return false;
    }

    /**
     * Set the state of the watch. Supposed to be set internally, so it is a protected method.
     *
     * @param $state State to be set.
     * @return bool Returns true if state is set successfully, false otherwise.
     */
    protected function setState($state)
    {
        $state = intval($state);

        if ($state < 0 || $state > 4) {
            return false;
        }

        $this->state = $state;
        return true;
    }

    /**
     * Return current state of the watch.
     *
     * @return int current `state` of the watch.
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Get the name of watch
     *
     * @return string Name of watch.
     */
    public function getName()
    {
        return $this->name;
    }
}