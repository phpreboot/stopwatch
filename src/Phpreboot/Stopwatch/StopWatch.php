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

use Phpreboot\Stopwatch\Timer;

class StopWatch
{
    const STOPWATCH_DEFAULT_NAME = "default_watch_R@nd0m_n@m3";

    private $timers;

    /**
     * Constructor to create new StopWatch instance with default watch.
     */
    public function __construct()
    {
        $this->timers = array();
        $this->addWatch(self::STOPWATCH_DEFAULT_NAME);
    }

    public function start($name = self::STOPWATCH_DEFAULT_NAME)
    {
        if (!$this->isWatchExist($name)) {
            return false;
        }

        return $this->getWatch($name)->start();
    }

    public function pause($name = self::STOPWATCH_DEFAULT_NAME)
    {
        if (!$this->isWatchExist($name)) {
            return false;
        }

        return $this->getWatch($name)->pause();
    }

    public function stop($name = self::STOPWATCH_DEFAULT_NAME)
    {
        if (!$this->isWatchExist($name)) {
            return false;
        }

        return $this->getWatch($name)->stop();
    }

    public function getTime($name = self::STOPWATCH_DEFAULT_NAME)
    {
        if (!$this->isWatchExist($name)) {
            return -1;
        }

        return $this->getWatch($name)->getTime();
    }

    public function isWatchExist($name)
    {
        return array_key_exists($name, $this->timers);
    }

    /**
     * Add a new watch to the StopWatch.
     *
     * @param string $name Name of watch to be added.
     * @return bool True if watch added successfully, false otherwise.
     */
    public function addWatch($name)
    {
        if (array_key_exists($name, $this->timers)) {
            return false;
        }

        $watch = new Timer($name);
        $this->timers[$name] = $watch;

        return true;
    }

    public function addWatches(array $watches)
    {
        $isWatchAdded = array();

        if (empty($watches)) {
            return $isWatchAdded;
        }

        foreach ($watches as $watch) {
            $isWatchAdded[] = $this->addWatch($watch);
        }

        return $isWatchAdded;
    }

    /**
     * Get a watch by name of watch.
     *
     * @param string $name Name of watch
     * @throws \InvalidArgumentException In case watch with name '$name' does not exist.
     * @return Timer A watch instance with name '$name'.
     */
    public function getWatch($name = self::STOPWATCH_DEFAULT_NAME)
    {
        if (!array_key_exists($name, $this->timers)) {
            throw new \InvalidArgumentException('Watch ' . $name . ' does not exist.');
        }

        return $this->timers[$name];
    }

    public function getWatchCount()
    {
        return count($this->timers);
    }
}