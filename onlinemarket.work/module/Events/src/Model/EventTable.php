<?php
namespace Events\Model;
class EventTable extends BaseModel
{
    public static $tableName = 'event';
    public function findAll()
    {
        return $this->tableGateway->select();
    }
    public function findById($eventId)
    {
        return $this->tableGateway->select(['id' => $eventId])->current();
    }
}
