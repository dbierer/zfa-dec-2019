<?php
namespace Login\Form\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\Hydrator\ClassMethodsHydrator;

use Login\Form\Question as QuestionForm;

class QuestionFormFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        $form = new QuestionForm();
        $form->addElements();
        $form->addInputFilter();
        $form->setHydrator(new ClassMethodsHydrator());
        return $form;
    }
}
