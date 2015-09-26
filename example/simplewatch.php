<?php

/*
 * This file is part of the PHPReboot/Stopwatch package.
 *
 * (c) Kapil Sharma <kapil@phpreboot.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/*
 * This example shows simple use of Stopwatch. For simple use, we need just four steps:
 *   - Create instance of StopWatch,
 *   - Call `start()` method to start the timer,
 *   - Call `stop()` method to stop the watch, and
 *   - Call `getTime()` method to get the time between start and stop.
 */

// Load Composer auto loader
require_once "../vendor/autoload.php";

use Phpreboot\Stopwatch\StopWatch;

// Create an instance of StopWatch
$stopWatch = new StopWatch();

// Start the watch to start timer,
$stopWatch->start();

$iteration = 0;

for ($i = 0; $i < 10000; $i++) {
    for ($j = 0; $j < 10000; $j++) {
        $iteration++;
    }
}

// Stop the watch.
$stopWatch->stop();

// By default, it will return time in seconds
$time = $stopWatch->getTime();

printf("Time taken for %d iterations was %f seconds.\n", $iteration, $time);