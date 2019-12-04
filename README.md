# ZF Advanced -- Dec 2019

## TODO
* Look for a code example using the EventFeature
* Look up example of hydration chaining -- deep iteration (e.g. nested objects)
* Check on status of ZF/Laminas
  * Spoke with Maurice Kherlakian at Zend by Perforce: he confirmed ZF is moving to the Linux Foundation and will be called `Laminas`

## HOMEWORK
* For Wed 4 Dec 2019
  * Lab: TableGateway: review code
  * Lab: Entity Classes: review code
  * Copy the following files from `onlinemarket.work` in this repo to your VM `onlinemarket.work` project folder:
```
/onlinemarket.work/module/Events/config/module.config.php
/onlinemarket.work/module/Events/src/Controller/AdminController.php
/onlinemarket.work/module/Events/src/Controller/AjaxController.php
/onlinemarket.work/module/Events/src/Controller/SignupController.php
/onlinemarket.work/module/Events/src/Entity/Attendee.php
/onlinemarket.work/module/Events/src/Entity/Registration.php
/onlinemarket.work/module/Events/src/Model/AttendeeTable.php
/onlinemarket.work/module/Events/src/Model/Base.php
/onlinemarket.work/module/Events/src/Model/RegistrationTable.php
/onlinemarket.work/module/Events/src/Module.php
/onlinemarket.work/module/Events/view/events/signup/reg-form.phtml
/onlinemarket.work/module/Market/src/Form/PostForm.php
/onlinemarket.work/module/Market/view/market/post/index.phtml
```

## ERRATA
* file:///D:/Repos/ZF-Level-2/Course_Materials/index.html#/2/8: `->join(['a' => static::TABLE],` s/be `->join(['a' => AttendeeTable::TABLE],`
