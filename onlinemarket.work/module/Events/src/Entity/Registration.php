<?php
namespace Events\Entity;

use Zend\Form\Annotation as ABC;

/**
 * Database Structure:
    CREATE TABLE `registration` (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `event_id` int(11) NOT NULL,
      `first_name` varchar(255) NOT NULL,
      `last_name` varchar(255) NOT NULL,
      `registration_time` datetime NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;
 */
class Registration extends Base
{
    //*** LAB: Entity Classes: Define public properties corresponding to the `registration` table columns
    //*** LAB: Forms and Fieldsets: Define annotations to create a registration form
}
