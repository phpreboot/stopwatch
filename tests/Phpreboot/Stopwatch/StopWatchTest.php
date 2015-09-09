<?php
/**
 * Created by PhpStorm.
 * User: kapil
 * Date: 09/09/15
 * Time: 11:56 PM
 */

namespace Phpunit\Stopwatch;

use Phpreboot\Stopwatch\StopWatch;
use Phpreboot\Stopwatch\Watch;


class StopWatchTest extends \PHPUnit_Framework_TestCase
{
    /** @var  StopWatch $stopWatch */
    private $stopWatch;

    public function setUp()
    {
        $this->stopWatch = new StopWatch();
    }

    public function testDown()
    {
        $this->stopWatch = null;
    }

    public function testStopwatchHaveDefaultWatch()
    {
        $defaultWatch = $this->stopWatch->getWatch();

        $this->assertNotNull($defaultWatch, "No watch available");
        $this->assertInstanceOf('Watch', $defaultWatch, "Not an instance of Watch");

    }
}