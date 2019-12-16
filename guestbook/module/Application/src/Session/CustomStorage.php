<?php
namespace Application\Session;

use Zend\StdLib\ArrayObject;
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;
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
        $result = $this->adapter->query('SELECT * FROM ' . self::TABLE_NAME . ' WHERE sess_id = ?', [$this->sessId]);
        if ($result) {
            foreach ($result as $obj) {
                if ($obj->count()) {
                    foreach ($obj->getArrayCopy() as $key => $value) {
                        $this->offsetSet($key, unserialize($value));
                    }
                }
            }
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
        // remove entries for this sess id
        $this->adapter->query('DELETE FROM ' . self::TABLE_NAME . ' WHERE sess_id = ?', [$this->sessId]);
        // get current sessId
        $this->sessId = session_id();
        if ($this->storage && count($this->storage)) {
            $stmt = $this->adapter->query('INSERT INTO ' . self::TABLE_NAME . ' (`sess_id`,`key`,`value`) VALUES (?,?,?)', Adapter::QUERY_MODE_PREPARE);
            foreach ($this->storage as $key => $value) {
                $stmt->execute([$this->sessId, $key, serialize($value)]);
            }
        }
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
