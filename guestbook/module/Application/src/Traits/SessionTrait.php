<?php
namespace Application\Traits;

trait SessionTrait
{
    protected $sessionContainer;
    protected $sessionManager;
    public function setSessionContainer($item)
    {
        $this->sessionContainer = $item;
        return $this;
    }
    public function setSessionManager($item)
    {
        $this->sessionManager = $item;
        return $this;
    }
}
