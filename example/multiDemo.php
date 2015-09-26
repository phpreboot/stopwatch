<?php

/*
 * This file is part of the PHPReboot/Stopwatch package.
 *
 * (c) Kapil Sharma <kapil@phpreboot.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

// Load Composer auto loader
require_once "../vendor/autoload.php";

use Phpreboot\Stopwatch\StopWatch;

$requiredWatches = ["a", "b", "c"];

// Create an instance of StopWatch
$stopWatch = new StopWatch();
$stopWatch->addWatches($requiredWatches);

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