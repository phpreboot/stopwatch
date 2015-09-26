# phpreboot/stopwatch

## Purpose

While optimizations, we need to check time taken by different operations. This soon becomes ugly, if we put many
`microtime` code blocks.

Purpose of StopWatch is to provide neat way of recording time taken by different blocks.

## Examples

Examples are given in example folder. To quick view, below are few examples:

### Simple stopwatch (file example/simplewatch.php)

Following example show use of StopWatch in simplest form.

```php
<?php

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
```