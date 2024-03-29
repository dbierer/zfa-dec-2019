<?php
//*** INITIALIZERS LAB: this factory will no longer be needed after the initializer has been created
namespace Market\Controller\Factory;

//use Market\Controller\IndexController;
use Interop\Container\ContainerInterface;
use Model\Table\ListingsTable;
use Zend\ServiceManager\Factory\FactoryInterface;

class IndexControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $controller = new IndexController();
		//*** INITIALIZERS LAB: the following line can be removed once the initializer has been created
        $controller->setListingsTable($container->get(ListingsTable::class));
        return $controller;
    }
}
