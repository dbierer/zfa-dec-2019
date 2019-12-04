<?php
namespace Events\Controller;

use Events\Traits\ {EventTableTrait, RegTableTrait, AttendeeTableTrait};
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AdminController extends AbstractActionController
{

    use EventTableTrait;
    use RegTableTrait;

    public function indexAction()
    {
        $eventId = $this->params()->fromRoute('eventId', FALSE);
        if ($eventId) {
        	//*** LAB: Table Module Relationships:
            //***      use any of the approaches covered in the slides to provide a list of registrations and associated attendees for a given event
			$registrations = ???;
            $viewModel = new ViewModel(['registrations' => $registrations]);
            $viewModel->setTemplate('events/admin/list');
        } else {
            $events = ???;
            $viewModel = new ViewModel(['events' => $events]);
        }
        return $viewModel;
    }

}
