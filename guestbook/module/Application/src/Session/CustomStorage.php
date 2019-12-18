<?php
namespace Application\Session;

use Zend\StdLib\ArrayObject;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Metadata\Metadata;
use Zend\Db\TableGateway\ {TableGateway, Feature\EventFeature, Feature\MetadataFeature};
use Zend\Session\Storage\StorageInterface;

class CustomStorage extends ArrayObject implements StorageInterface
{
    const TABLE_NAME = 'session_storage';

    protected $table, $adapter, $sessId, $sessMgr, $accessTime;
    protected $storage = [];
    protected $lock = [];
    protected $immutable = [];
    public function __construct(Adapter $adapter)
    {
        $this->sessId = session_id();
        $this->setRequestAccessTime(microtime(true));
        $this->adapter = $adapter;
        $metaFeature = new MetadataFeature(new Metadata($adapter));
        $this->table = new TableGateway(self::TABLE_NAME, $adapter, $metaFeature);
        $result = $this->table->select(['sess_id' =>$this->sessId]);
        $data = $result->current()['value'] ?? NULL;
        if ($data && is_string($data)) {
            $this->fromArray(unserialize($data));
        }
    }
    /**
     * Destructor
     *
     * Wipes out self::TABLE_NAME and re-inserts key/value pairs serialized
     *
     * @return void
     */
    public function __destruct()
    {
        // remove entries for old sess id
        $oldSessId = $this->sessId;
        $newSessId = session_id();
        $this->table->delete(['sess_id' => $oldSessId]);
        if ($oldSessId != $newSessId) {
            $this->table->delete(['sess_id' => $newSessId]);
            $this->sessId = $newSessId;
        }
        $this->table->insert(['sess_id' => $this->sessId, 'key' => date('Y-m-d H:i:s'), 'value' => serialize($this->toArray())]);
    }

    public function getRequestAccessTime()
    {
        return $this->accessTime;
    }
    public function setRequestAccessTime($ts)
    {
        $this->accessTime = $ts;
        return $this;
    }
    public function lock($key = null)
    {
        $key = $key ?? __CLASS;
        $this->lock[$key] = TRUE;
        return $this;
    }
    public function isLocked($key = null)
    {
        $key = $key ?? __CLASS;
        return $this->lock[$key] ?? FALSE;
    }
    public function unlock($key = null)
    {
        $key = $key ?? __CLASS;
        $this->lock[$key] = FALSE;
        return $this;
    }

    public function markImmutable()
    {
        $this->immutable = TRUE;
        return $this;
    }
    public function isImmutable()
    {
        return $this->immutable;
    }

    public function setMetadata($key, $value, $overwriteArray = false)
    {
        if (! isset($this->storage['__ZF'])) {
            $this->storage['__ZF'] = [];
        }

        if (isset($this->storage['__ZF'][$key]) && is_array($value)) {
            if ($overwriteArray) {
                $this->storage['__ZF'][$key] = $value;
            } else {
                $this->storage['__ZF'][$key] = array_replace_recursive($this->storage['__ZF'][$key], $value);
            }
        } else {
            if ((null === $value) && isset($this->storage['__ZF'][$key])) {
                // unset($this->storage['__ZF'][$key]) led to "indirect modification...
                // has no effect" errors, so explicitly pulling array and
                // unsetting key.
                $array = $this->storage['__ZF'];
                unset($array[$key]);
                $this->storage['__ZF'] = $array;
                unset($array);
            } elseif (null !== $value) {
                $this->storage['__ZF'][$key] = $value;
            }
        }

        return $this;
    }
    public function getMetadata($key = null)
    {
        if (! isset($this->storage['__ZF'])) {
            return false;
        } elseif (null === $key) {
            return $this->storage['__ZF'];
        } elseif (! array_key_exists($key, $this->storage['__ZF'])) {
            return false;
        } else {
            return $this->storage['__ZF'][$key];
        }
    }
    public function clear($key = null)
    {
        if ($key === NULL) {
            $this->storage = [];
        } elseif (isset($this->storage[$key])) {
            unset($this->storage[$key]);
        }
        return $this;
    }
    public function fromArray(array $array)
    {
        $ts = $this->accessTime;
        $this->exchangeArray($array);
        $this->setRequestAccessTime($ts);

        return $this;
    }
    public function toArray($metaData = false)
    {
        $values = $this->storage;
        if (!$metaData) {
            if (isset($values['__ZF'])) {
                unset($values['__ZF']);
            }
        }
        return $values;
    }
}
