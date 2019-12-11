<?php
namespace TestZf2\Listener;

use Zend\Mvc\MvcEvent;
use Zend\EventManager\ {AbstractListenerAggregate,EventManagerInterface,EventInterface};

class SwapAutoload extends AbstractListenerAggregate
{

    const EVENT_PUSH_ZF2_AUTOLOADER = 'event-push-zf2-autoloader';
    const EVENT_POP_ZF2_AUTOLOADER  = 'event-pop-zf2-autoloader';

    public function attach(EventManagerInterface $e, $priority = 100)
    {
        $shared = $e->getSharedManager();
        $this->listeners[] = $shared->attach('*', self::EVENT_PUSH_ZF2_AUTOLOADER, [$this, 'pushZf2Autoloader']);
        $this->listeners[] = $shared->attach('*', self::EVENT_POP_ZF2_AUTOLOADER, [$this, 'popZf2Autoloader']);
    }
    /**
     * Prepends ZF2 class map autoloader onto stack
     *
     * @param EventInterface $event
     */
    public function pushZf2Autoloader(EventInterface $e)
    {
        // creates instance of ClassMapAutoloader
        // initializes it with `autoload_classmap.php` from ZF2_Project
        // prepends it onto spl autoload stack using "prepend" option
        // see: https://www.php.net/manual/en/function.spl-autoload-register.php
    }
    /**
     * Removes ZF2 class map autoloader from stack
     *
     * @param EventInterface $event
     */
    public function popZf2Autoloader(EventInterface $e)
    {
        // removes ClassMapAutoloader from spl autoload stack
        // see: https://www.php.net/manual/en/function.spl-autoload-functions.php
        // see: https://www.php.net/manual/en/function.spl-autoload-unregister.php
    }
}
