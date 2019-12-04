<?php
namespace Events\Controller;

use Events\Traits\ {EventTableTrait, RegTableTrait, AttendeeTableTrait};
use Events\Model\ {EventModel, RegistrationModel, AttendeeModel};
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ {ViewModel, JsonModel};

class AjaxController extends AbstractActionController
{

    use RegTableTrait;
    use AttendeeTableTrait;

	//*** LAB: Table Module Relationships: only define this if you choose the AJAX approach
    public function registrationAction()
    {
        $eventId = $this->params('eventId');
        $registrations = $this->regTable->findRegByEventId($eventId);
        $data = [];
        if ($registrations) {
        	//*** LAB: Table Module Relationships:provide secondary data table which performs lookups for attendees for each registration
        }
        return new JsonModel(['data' => $data]);
    }
    public function attendeeAction()
    {
        $regId = $this->params('regId');
        $attendees = $this->attendeeTable->findByRegId($regId);
        $data = [];
        if ($attendees) {
            foreach ($attendees as $item) {
                $data[] = [$item->getNameOnTicket()];
            }
        }
        return new JsonModel(['data' => $data]);
    }
	//*** LAB: Forms and Fieldsets: add action method which returns Attendee sub-form instance with next ticket #
    public function getAttendeeForm($ticketNum)
    {
        $form = ???;
        return new JsonModel(['form' => $form]);
    }

}
