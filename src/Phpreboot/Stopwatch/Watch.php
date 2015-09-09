<?php
/**
 * Created by PhpStorm.
 * User: kapil
 * Date: 10/09/15
 * Time: 12:07 AM
 */

namespace Phpreboot\Stopwatch;


class Watch
{
    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }
}