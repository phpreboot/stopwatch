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

use Phpreboot\Stopwatch\Watch;

class StopWatch
{
    const STOPWATCH_DEFAULT_NAME = "default";

    private $watches;

    /**
     * Constructor to create new StopWatch instance with default watch.
     */
    public function __construct()
    {
        $this->watches = array();
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
        
    }

    public function isWatchExist($name)
    {
        return array_key_exists($name, $this->watches);
    }

    /**
     * Add a new watch to the StopWatch.
     *
     * @param string $name Name of watch to be added.
     * @return bool True if watch added successfully, false otherwise.
     */
    public function addWatch($name)
    {
        if (array_key_exists($name, $this->watches)) {
            return false;
        }

        $watch = new Watch($name);
        $this->watches[$name] = $watch;

        return true;
    }

    public function addWatches(array $watches)
    {
        $isWatchAdded = false;

        if (empty($watches)) {
            return $isWatchAdded;
        }

        foreach ($watches as $watch) {
            $this->addWatch($watches);
            $isWatchAdded = true;
        }

        return $isWatchAdded;
    }

    /**
     * Get a watch by name of watch.
     *
     * @param string $name Name of watch
     * @throws \InvalidArgumentException In case watch with name '$name' does not exist.
     * @return Watch A watch instance with name '$name'.
     */
    public function getWatch($name = self::STOPWATCH_DEFAULT_NAME)
    {
        if (!array_key_exists($name, $this->watches)) {
            throw new \InvalidArgumentException('Watch ' . $name . ' does not exist.');
        }

        return $this->watches[$name];
    }

    public function getWatchCount()
    {
        return count($this->watches);
    }
}