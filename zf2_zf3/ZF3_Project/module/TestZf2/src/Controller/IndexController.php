<?php
namespace TestZf2\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    protected $model;
    /**
     * @param ZF2_Project::Lookup\Model\UserModel $model
     */
    public function __construct($model)
    {
        $this->model = $model;
    }
    public function indexAction()
    {
        $list = $this->model->fetchAll();
        return new ViewModel(['list' => $list]);
    }
}
