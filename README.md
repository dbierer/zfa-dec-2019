# ZF Advanced -- Dec 2019

## TODO
* Q: When using listener aggregates which are invoked via the service manager, are instances created immediately?
     If this is the case, is there a solution in situations where there are massive dependencies?
* A: [`Zend\Mvc\Application::init()`](https://github.com/zendframework/zend-mvc/blob/master/src/Application.php) consolidates all listeners listed the under the `listeners` key.  `init()` then calls `bootstrap()` providing the list of listeners as an argument. This means that any listener aggregate defined by service manager factory will have an instance created.  The actual listener method, however, is *not* called until the event is triggered.  So, if the "heavy" logic is in the listener aggregate `__construct()` method, performance is affected negatively.  However, if the "heavy" logic is in the listener method itself, performance is not affected until the event associated with the listener is triggered.
* A: To avoid having listeners-as-services be created right away regardless of need, use [`Zend\EventManager\LazyListenerAggregate`](https://docs.zendframework.com/zend-eventmanager/lazy-listeners/lazy-listener-aggregate/).

* Q: Can we use delegators to run ZF2 code from ZF3?  Examples?
* A: See `zf2_zf3` in this repo.  ***WORK IN PROGRESS***

* Q: Can you pass params to your own custom services?
* Q: If not specified as an attribute, is the `id` HTML input attribute auto-generated by Zend\Form?
* Q: Sometimes `Zend\Form\Element\Csrf` rejects form submissions for no apparent reason.  Any ideas on this?

## HOMEWORK
* For Wed 11 Dec 2019
  * Lab: Abstract Factories
  * Lab: Delegators
  * NOTE: need to create `/data/auth` directory for Authentication/ACL labs to work
    * Also: set write permissions to `www-data` user
  * Copy the following files from `onlinemarket.work` in this repo to your VM `onlinemarket.work` project folder:
```
onlinemarket.work/module/Login/*
onlinemarket.work/module/AccessControl/*
# copy layout.phtml to ~/Zend/workspaces/DefaultWorkspace/onlinemarket.work/module/Application/view/layout
```
* Not Yet Assigned:
  * Lab: Logging
    * Activate and complete the `Logging` module
  * Lab: Zend Mail
    * Add the email notification to `Market\Controller\PostController` when an onlinemarket posting is made
* For Mon 9 Dec 2019
  * [OPTIONAL] Lab: File Uploads
  * [OPTIONAL] Lab: Form Security
  * Lab: Initializers
  * Copy the following 2 files from `onlinemarket.work` in this repo to your VM `onlinemarket.work` project folder:
```
onlinemarket.work/module/Market/src/Module.php
onlinemarket.work/module/Market/src/Controller/Factory/ViewControllerFactory.php
```
* For Wed 4 Dec 2019
  * Lab: TableGateway
  * Lab: Entity Classes
  * Lab: Object Hydration and Database Operations
  * Lab: Table Module Relationships
  * Lab: Forms and Fieldsets:
    * Action item #5 is optional
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
* Q: Where are `$options` passed in by services created by ServiceManager or derivatives?
* A: These are used by specialized `ServiceManager` derivatives (e.g. RoutePluginManager) which then pass params (e.g. "route->type, route->defaults, etc.")
* Q: How can I restore form data if user has to resubmit?
* A: See: https://docs.zendframework.com/zend-mvc-plugin-prg/


## ERRATA
* file:///D:/Repos/ZF-Level-2/Course_Materials/index.html#/2/8: `->join(['a' => static::TABLE],` s/be `->join(['a' => AttendeeTable::TABLE],`
* file:///D:/Repos/ZF-Level-2/Course_Materials/index.html#/3/19: if `name` param is not specified for the FieldSet, how is it referenced?
* file:///D:/Repos/ZF-Level-2/Course_Materials/index.html#/4/32: does this syntax work?  maybe need a namespace classname as a key, not just `param1` etc.
* file:///D:/Repos/ZF-Level-2/Course_Materials/index.html#/5/21: `listeners` key needs to be at the top level (e.g. parallel to `service_manager`) in the `module.config.php` file
