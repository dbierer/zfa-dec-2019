<?php
namespace AccessControl\Assertion;

use DateTime;
//*** ACL LAB: use the appropriate classes

class DateTimeAssert implements AssertionInterface
{
    protected $startTime;
    protected $stopTime;
    public function __construct(DateTime $start, DateTime $stop)
    {
        $this->startTime = $start;
        $this->stopTime = $stop;
    }

    //*** ACL LAB: return a boolean which asserts current date/time is between startTime and stopTime
    public function assert()
    {
        return '???';
    }
}
