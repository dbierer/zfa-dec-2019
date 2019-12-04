<?php
//*** CACHE LAB
namespace Market\Listener;

use Market\Controller\MarketController;

use Zend\Mvc\MvcEvent;
use Zend\EventManager\ {AbstractListenerAggregate,EventManagerInterface};
use Application\Traits\ServiceContainerTrait;

class CacheAggregate extends AbstractListenerAggregate
{

    const EVENT_CLEAR_CACHE = 'market-event-clear-cache';

    use ServiceContainerTrait;

	protected $cacheKey = '';
	protected $routeMatch = NULL;
	protected $cacheAdapter;
	
    public function attach(EventManagerInterface $e, $priority = 100)
    {
        //*** attach a series of listeners using the shared manager
        $shared = $e->getSharedManager();
        //*** CACHE LAB: attach a listener to get the page view from cache
        //*** CACHE LAB: attach a listener which listens at the very end of the cycle and check to see if the "mustCache" param has been set
        //*** CACHE LAB: attach a listener to clear cache if EVENT_CLEAR_CACHE is triggered
    }
    public function clearCache($e)
    {
		$this->cacheAdapter->flush();
		error_log(date('Y-m-d H:i:s') . ': Cleared Cache');
    }
    //*** configure this to check to see if the "ViewController" has been chosen
    //*** if so, check to see if the response object has been cached and return it
    //*** otherwise set a param "mustCache" to indicate this page view should be cached
    public function getPageViewFromCache(MvcEvent $e)
    {
    }
    public function storePageViewToCache(MvcEvent $e)
    {
        //*** complete the logic for this method
    }
    protected function generateCacheKey()
    {
		$cacheKey   = str_replace('/', '_', $this->routeMatch->getMatchedRouteName()) . '_';
		if ($itemId = $this->routeMatch->getParam('itemId')) {
			$cacheKey .= $itemId;
		} elseif ($category = $this->routeMatch->getParam('category')) {
			$cacheKey .= $category;
		}
		return $cacheKey;
	}
	public function setCacheAdapter($cacheAdapter)
	{
		$this->cacheAdapter = $cacheAdapter;
	}

}
