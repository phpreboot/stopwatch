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

    public function pause()
    {
        if ($this->state !== self::STATE_STARTED) {
            return false;
        }

        $time = microtime();

        $this->runtime += ($time - $this->startTime);
        $this->startTime = null;
        $this->setState(self::STATE_PAUSED);

        return true;
    }

    public function start()
    {
        if (!$this->canStart()) {
            return false;
        }

        $this->startTime = microtime();

        //TODO: Although no chance of validation error, we must set start time to 'null' in case of validation error.
        return $this->setState(self::STATE_STARTED);
    }

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
     * Get the name of watch
     *
     * @return string Name of watch.
     */
    public function getName()
    {
        return $this->name;
    }
}