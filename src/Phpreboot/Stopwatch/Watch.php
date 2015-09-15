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

    /**
     * Constructor
     *
     * @param string $name Name of new watch
     */
    public function __construct($name)
    {
        $this->name = $name;
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