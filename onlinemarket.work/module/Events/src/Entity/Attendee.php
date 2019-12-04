<?php
namespace Events\Entity;

use Zend\Form\Annotation as ABC;

/**
 * Database Structure:
    CREATE TABLE `attendee` (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `registration_id` int(11) NOT NULL,
      `name_on_ticket` varchar(255) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8;
 */
class Attendee extends Base
{
    //*** LAB: Entity Classes: Define public properties corresponding to the `attendee` table columns
    //*** LAB: Forms and Fieldsets: Define annotations to create an attendee form
}
