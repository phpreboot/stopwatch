# phpreboot/stopwatch

[![Build Status](https://travis-ci.org/phpreboot/stopwatch.svg?branch=master)](https://travis-ci.org/phpreboot/stopwatch) [![HHVM Status](http://hhvm.h4cc.de/badge/phpreboot/stopwatch.svg)](http://hhvm.h4cc.de/package/phpreboot/stopwatch) [![Code Climate](https://codeclimate.com/github/phpreboot/stopwatch/badges/gpa.svg)](https://codeclimate.com/github/phpreboot/stopwatch) [![Test Coverage](https://codeclimate.com/github/phpreboot/stopwatch/badges/coverage.svg)](https://codeclimate.com/github/phpreboot/stopwatch/coverage) [![Software License](https://img.shields.io/badge/License-MIT-brightgreen.svg)](https://github.com/phpreboot/stopwatch/blob/master/LICENSE)

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/c0bbc196-0cff-4362-b286-9f1b3b7cd445/big.png)](https://insight.sensiolabs.com/projects/c0bbc196-0cff-4362-b286-9f1b3b7cd445)

## Purpose

While optimizations, we need to check time taken by different operations. This soon becomes ugly, if we put many
`microtime` code blocks.

Purpose of StopWatch is to provide neat way of recording time taken by different blocks.

### Supported versions

Above build is tested code on PHP version 5.3, 5.4, 5.5, 5.6, 7.0 and HHVM. Check `.travis.yml` for details.

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

### Pause demo (file example/pausedemo.php)

This example shows measuring time in multiple intervals. We simply pause watch to stop timer and start it again later.
This step can be repeated multiple times.

```php
<?php

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
```

### Multi demo (file example/multiDemo.php)

Measuring time in multiple intervals is useful but there are times when we need multiple stopwatches, independent
of each others. Following example shows how can we have multiple stopwatches.

```php
<?php

/*
 * This example shows using multiple stop watches in the same program.
 * If we want to use multiple watches, we must provide unique name all of them.
 * Steps involved are:
 *   - Add watches by any of following methods
 *     - Call `addWatch` multiple times, with name of watch as parameter, or
 *     - Call `addWatches` and pass an array of name of watches as parameter.
 *   - Further operation is same as in `simplewatch` and `pauseDemo` example. However this time, we need to pass
 *     watch name to all the methods.
 */

// Load Composer auto loader
require_once "../vendor/autoload.php";
use Phpreboot\Stopwatch\StopWatch;

// Create an instance of StopWatch
$stopWatch = new StopWatch();

// Initialize the watches.
$stopWatch->addWatches(["a", "b", "c"]);
// We could also use
// $stopWatch->addWatch("a");
// $stopWatch->addWatch("b");
// $stopWatch->addWatch("c");

$operatorA = 0;
$operatorB = 0;
$operatorC = 0;

for ($i = 1; $i <= 10; $i++) {
    // Following code block represent one operation, which needs to be measured.
    $stopWatch->start("a");
    for ($a = 0; $a < 10000; $a++) {
        $operatorA++;
    }
    $stopWatch->pause("a");

    // Following code block represent another operation, which needs to be measured separately.
    $stopWatch->start("b");
    for ($b = 0; $b < 10000; $b++) {
        $operatorB++;
    }
    $stopWatch->pause("b");

    // One more operation, independent of above operations needs to be measured.
    $stopWatch->start("c");
    for ($c = 0; $c < 10000; $c++) {
        $operatorC++;
    }
    $stopWatch->pause("c");
}

printf("Time taken in block 'a': %f seconds.\n", $stopWatch->getTime("a"));
printf("Time taken in block 'b': %f seconds.\n", $stopWatch->getTime("b"));
printf("Time taken in block 'c': %f seconds.\n", $stopWatch->getTime("c"));
```
