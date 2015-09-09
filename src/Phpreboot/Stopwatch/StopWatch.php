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

    public function __construct($name = self::STOPWATCH_DEFAULT_NAME)
    {
        $this->watches = array();
        $this->addWatch($name);
    }

    public function addWatch($name)
    {
        if (array_key_exists($name, $this->watches)) {
            return false;
        }

        $watch = new Watch($name);

        $this->watches[$name] = $watch;
    }

    /**
     * @param string $name Name of watch
     * @return Watch
     */
    public function getWatch($name = self::STOPWATCH_DEFAULT_NAME)
    {
        if (!array_key_exists($name, $this->watches)) {
            throw new \InvalidArgumentException('Watch ' . $name . ' does not exist.');
        }

        return $this->watches[$name];
    }
}