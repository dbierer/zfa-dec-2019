<?php
namespace Events\Model;

use Events\Entity\Attendee;

class AttendeeTable extends BaseModel
{
    public static $tableName = 'attendee';
    public function findByRegId($regId)
    {
        //*** LAB: TABLEGATEWAY: return an Attendee instance given a registration ID
    }
    public function save(Attendee $attendee)
    {
        //*** LAB: TABLEGATEWAY: given an Attendee instance, insert into or update the database; return the last insert ID
    }
}
