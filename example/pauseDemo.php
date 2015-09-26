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
 * The example shows how to pause the timer for measuring time at different stages.
 * Once watch is started, we can call `pause` method to pause the watch.
 * If watch is paused, we can start it again to start timer. In that case, time will be added to timer.
 */

// Load Composer auto loader
require_once "../vendor/autoload.php";

use Phpreboot\Stopwatch\StopWatch;

// Create an instance of StopWatch
$stopWatch = new StopWatch();

$innerIterator = 0;

for ($i = 1; $i <= 10; $i++) {
    printf("Iteration %d starting.\n", $i);

    $stopWatch->start();
    for ($j = 0; $j < 1000; $j++) {
        $innerIterator++;
    }
    $stopWatch->pause();

    printf("Iteration %d watch stopped, not other task is starting..\n", $i);

    for ($k = 0; $k < 1000; $k++) {
        $timeWaster = $k;
    }
}

printf("Time taken by first loop (\$j), for %d iterations was: %f seconds.\n", $innerIterator, $stopWatch->getTime());