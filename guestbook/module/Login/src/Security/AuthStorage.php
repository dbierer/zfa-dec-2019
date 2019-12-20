<?php
namespace Login\Security;

use Zend\Authentication\Storage\StorageInterface;

class AuthStorage implements StorageInterface
{

    const AUTH_PREFIX = 'auth_';
    const AUTH_FN_DEFAULT = 'default';
    const ERROR_STORAGE_DIR = 'ERROR: storage file directory does not exist: ';
    protected $dir;
    protected $fn = '';

    public function __construct(string $dir)
    {
        if (!file_exists($dir)) {
            throw new Exception(self::ERROR_STORAGE_DIR . $dir);
        }
        $this->dir = $dir;
        $this->fn  = $dir . '/' . self::AUTH_PREFIX . session_id();
        $this->fn  = str_replace('//', '/', $this->fn);
    }
    public function __destruct()
    {
        // @TODO: need to write code which erases old session files
    }
    /**
     * Returns true if and only if storage is empty.
     *
     * @return boolean
     * @throws \Zend\Authentication\Exception\ExceptionInterface If it is
     *     impossible to determine whether storage is empty.
     */
    public function isEmpty()
    {
        return file_exists($this->fn);
    }

    /**
     * Returns the contents of storage.
     *
     * Behavior is undefined when storage is empty.
     *
     * @return mixed
     * @throws \Zend\Authentication\Exception\ExceptionInterface If reading
     *     contents from storage is impossible
     */

    public function read()
    {
        $result = FALSE;
        if (file_exists($this->fn)) {
            $result = unserialize(file_get_contents($this->fn));
        }
        return $result;
    }

    /**
     * Writes $contents to storage.
     *
     * @param  mixed $contents
     * @return void
     * @throws \Zend\Authentication\Exception\ExceptionInterface If writing
     *     $contents to storage is impossible
     */

    public function write($contents)
    {
        file_put_contents($this->fn, serialize($contents));
    }

    /**
     * Clears contents from storage.
     *
     * @return void
     * @throws \Zend\Authentication\Exception\ExceptionInterface If clearing
     *     contents from storage is impossible.
     */

    public function clear()
    {
        unlink($this->fn);
    }
}
