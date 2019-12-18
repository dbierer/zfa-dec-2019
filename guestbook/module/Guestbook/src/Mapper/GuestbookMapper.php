<?php
namespace Guestbook\Mapper;

use Guestbook\Model\Guestbook as GuestbookModel;
use Zend\Db\Sql\ {Sql,Expression};
use Zend\Db\Adapter\Adapter;
use Zend\Db\Metadata\Metadata;
use Zend\Db\TableGateway\ {TableGateway, Feature\EventFeature, Feature\MetadataFeature};
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Hydrator\ObjectPropertyHydrator;
use Zend\EventManager\EventManager;

class GuestbookMapper
{

    const TABLE_NAME   = 'guestbook';
    const IDENTIFIER   = 'guestbook-mapper';
    const ADD_EVENT    = 'guestbook-mapper-add-event';

    protected $table;
    protected $adapter;
    protected $eventManager;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->eventManager = new EventManager();
        $this->eventManager->addIdentifiers([self::IDENTIFIER]);
        // set up features
        $metaFeature = new MetadataFeature(new Metadata($adapter));
        $eventFeature = new EventFeature($this->eventManager);
        // set up tablegateway with hydrating result set + features
        $resultSet = new HydratingResultSet(new ObjectPropertyHydrator(), new GuestbookModel);
        $this->table = new TableGateway(self::TABLE_NAME, $adapter, [$eventFeature, $metaFeature], $resultSet);
    }
    public function findAll()
    {
        return $this->table->select();
    }
    public function getCount()
    {
        $sql = new Sql($this->table->getAdapter());
        $select = $sql->select()->from(self::TABLE_NAME)
                                ->columns(['val' => new Expression('COUNT(id)')]);
        return $this->table->selectWith($select);
    }
    public function add(GuestbookModel $model)
    {
        $hydrator = $this->table->getResultSetPrototype()->getHydrator();
		$data = $hydrator->extract($model);
        unset($data['submit']);
        unset($data['hash']);
        $data['dateSigned'] = date('Y-m-d H:i:s');
        $result = $this->table->insert($data);
        $this->eventManager->trigger(self::ADD_EVENT, $this, ['model' => $model]);
        return $result;
    }
    public function getEventManager()
    {
        return $this->eventManager;
    }
}
