<?php
namespace Events\Model;

use Events\Listener\Event as RegEvent;
use Events\Entity\ {Event,Registration,Attendee};
use Zend\Db\Sql\ {Sql,Where};

// Table Structure:
/*
CREATE TABLE `registration` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `registration_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8
 */

class RegistrationTable extends BaseModel
{
    public static $tableName = 'registration';
    public function findRegByEventId($eventId)
    {
        $sql = new Sql($this->tableGateway->getAdapter());
        $select = $sql->select();
        $select->from(['r' => self::$tableName])->where(['r.event_id' => $eventId])->order('r.registration_time DESC');
        return $this->tableGateway->selectWith($select);
    }
    public function findAllRegistrationsForEvent(Event $event)
    {
        //*** LAB: TABLEGATEWAY: given an Event instance, return an iteration of Registration entities for this event
    }
    public function save(Registration $reg)
    {
        //*** LAB: TABLEGATEWAY: given a Registration instance, insert into or update the database; return the last insert ID
    }
}
