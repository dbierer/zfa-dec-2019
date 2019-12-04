# ZF Advanced -- Dec 2019

## TODO

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

## Q & A
* Q: Do you have any examples of code using `EventFeature`?
* A: In the VM look at the following classes: `Guestbook\Module` and `Guestbook\Mapper\GuestbookMapper`
* Q: Do you have any examples of hydration chaining -- deep iteration (e.g. nested objects)
* A: In the VM, in the `onlinemarket.complete` project, have a look at the following classes:
  * Custom Hydrator: `Model\Hydrator\ListingsHydrator`
  * Hydrator Chaining: see: https://github.com/dbierer/zf-master-aug-2019/blob/master/sandbox/public/events_aggregate_hydrator.php
  * Examples of hydrator filters and strategies: see: https://github.com/dbierer/zf-master-aug-2019/tree/master/sandbox/public
* Q: What is the status of ZF/Laminas?
* A: Spoke with Maurice Kherlakian at Zend by Perforce: he confirmed ZF is moving to the Linux Foundation and will be called `Laminas`
  * See: https://www.zend.com/blog/what-status-zend-framework-transition-laminas?utm_source=linkedin&utm_medium=social&utm_campaign=2019-zend-blog-what-status-zend-framework-transition-laminas&utm_content=blog


## ERRATA
* file:///D:/Repos/ZF-Level-2/Course_Materials/index.html#/2/8: `->join(['a' => static::TABLE],` s/be `->join(['a' => AttendeeTable::TABLE],`
