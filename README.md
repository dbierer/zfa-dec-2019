# ZF Advanced -- Dec 2019

## TODO
* Q: How does the breadcrumbs navigation know what page is active?

* Q: How can you add a dynamic aspect to menus (e.g. when clicking on an event, have a database lookup provide info for submenus)?

* Q: Reference to article on how to implement ACLs for a group
* A: Read about the "MR_X" technique: https://www.zend.com/blog/zend-framework-acls-users-multiple-roles

* Q: How would you implement database *row* level security?  Using ACL?

* Q: `SecurePost` module: where is the code which swaps out the view?
* A: You can manipulate the `template_map` param to swap the view **** TODO ****

* Q: Can we use delegators to run ZF2 code from ZF3?  Examples?
* A: See `zf2_zf3` in this repo.  ***WORK IN PROGRESS***

* Make sure Guestbook app is working.  if not, get it working and post to this repo
  * Modify the menu structure for `Events` pulling `Event A`, `Event B`, etc. from the database + implement cache
  * Modify CustomStorage class to use TableGateway w/ MetadataFeature
  * Update the `zfcourse` database as follows:
```
mysql -uvagrant -pvagrant zfcourse ./guestbook/update.sql
```
  * *** WORK IN PROGRESS ***


## HOMEWORK
* For Wed 18 Dec 2019
  * Lab: ACL
  * Lab: Navigation
* For Mon 16 Dec 2019
  * Lab: Zend Mail
    * Add the email notification to `Market\Controller\PostController` when an onlinemarket posting is made
  * Lab: Authentication
  * Lab: Password Storage
* For Fri 13 Dec 2019
  * Lab: Cache
  * Lab: Sessions
  * Lab: Logging
    * Activate and complete the `Logging` module
    * Might need to extend the class and override `registerErrorHandler()` to account for PHP 7 error handling
    * To test: create a controller action that divides a number by zero, which should throw a `DivisionByZeroError`.
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
* Q: Documentation on adding an inline image or sending multi-part messages using Zend\Mail?
* A: See: https://docs.zendframework.com/zend-mail/message/attachments/

* Q: When using listener aggregates which are invoked via the service manager, are instances created immediately?
     If this is the case, is there a solution in situations where there are massive dependencies?
* A: [`Zend\Mvc\Application::init()`](https://github.com/zendframework/zend-mvc/blob/master/src/Application.php) consolidates all listeners listed the under the `listeners` key.  `init()` then calls `bootstrap()` providing the list of listeners as an argument. This means that any listener aggregate defined by service manager factory will have an instance created.  The actual listener method, however, is *not* called until the event is triggered.  So, if the "heavy" logic is in the listener aggregate `__construct()` method, performance is affected negatively.  However, if the "heavy" logic is in the listener method itself, performance is not affected until the event associated with the listener is triggered.
* A: To avoid having listeners-as-services be created right away regardless of need, use [`Zend\EventManager\LazyListenerAggregate`](https://docs.zendframework.com/zend-eventmanager/lazy-listeners/lazy-listener-aggregate/).

* Q: If not specified as an attribute, is the `id` HTML input attribute auto-generated by Zend\Form?
* A: No: you have to manually add it, such as the following example:
```
// from: Guestbook\Form\GuestbookForm::addElements()
$name = new Element\Text('name');
$name->setLabel('Name');
$name->setAttributes(['title' => 'Zend\\Form does not assign an "id" attributes unless you define it', 'id' => 'name']);
$this->add($name);
```


## ERRATA
* file:///D:/Repos/ZF-Level-2/Course_Materials/index.html#/2/8: `->join(['a' => static::TABLE],` s/be `->join(['a' => AttendeeTable::TABLE],`
* file:///D:/Repos/ZF-Level-2/Course_Materials/index.html#/3/19: if `name` param is not specified for the FieldSet, how is it referenced?
* file:///D:/Repos/ZF-Level-2/Course_Materials/index.html#/4/32: does this syntax work?  maybe need a namespace classname as a key, not just `param1` etc.
* file:///D:/Repos/ZF-Level-2/Course_Materials/index.html#/5/21: `listeners` key needs to be at the top level (e.g. parallel to `service_manager`) in the `module.config.php` file
* file:///D:/Repos/ZF-Level-2/Course_Materials/index.html#/5/71: descriptions of log destinations are reversed
* file:///D:/Repos/ZF-Level-2/Course_Materials/index.html#/6/6: `setCredential()` needs a plain text password as argument, not a hash!
* file:///D:/Repos/ZF-Level-2/Course_Materials/index.html#/6/7: `setCredential()` needs a plain text password as argument, not a hash!
* file:///D:/Repos/ZF-Level-2/Course_Materials/index.html#/6/12: s/use the pre-defined constants (see: https://github.com/zendframework/zend-ldap/blob/master/src/Ldap.php)
* file:///D:/Repos/ZF-Level-2/Course_Materials/index.html#/6/54: need to identify full namespace of AssertionInterface

## Class Notes
### JW Token
Here is an example of using a listener aggregate to capture JWT info:
```
<?php
namespace Application\Listener;

use Application\Model\ModelTrait;
use Application\Traits\ConfigTrait;
use Zend\Mvc\MvcEvent;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;

class Listener implements ListenerAggregateInterface
{
    use ConfigTrait;
    use ModelTrait;
    /**
     * Attach listeners to MvcEvent::EVENT_DISPATCH
     */
    public function attach(EventManagerInterface $e, $priority = 100)
    {
        $shared = $e->getSharedManager();
        $this->listeners[] = $shared->attach('*', MvcEvent::EVENT_ROUTE,  [$this, 'checkAuthorization'], -99);
    }
    /**
     * Required by the interface
     */
    public function detach(EventManagerInterface $e, $priority = 100)
    {
        // do nothing
    }
    /**
     * Check Authorized Token
     * @param type $event
     * @return type Description
     */
    public function checkAuthorization(MvcEvent $event)
    {
        $jsonData = [];
        $request = $event->getRequest();
        $response = $event->getResponse();
        $isAuthorizationRequired = $event->getRouteMatch()->getParam('isAuthorizationRequired');
        if ($isAuthorizationRequired) {
            $jwtToken = $this->getJwtToken($request);
            if ('' != $jwtToken) {
                if (!$this->authenticationModel->checkValidToken($jwtToken)) {
                    $response->setStatusCode(400);
                    $jsonData = [
                        $this->config['ApiKeys']['status'] => $this->config['messages']['errorNotOk'],
                        $this->config['ApiKeys']['result'] =>
                            [$this->config['ApiKeys']['error'] => $this->config['messages']['errorUnauthToken']],
                    ];
                    return $this->bailOut($response, $jsonData);
                }
            } else {
                $response->setStatusCode(401);
                $jsonData = [
                    $this->config['ApiKeys']['status'] => $this->config['messages']['errorNotOk'],
                    $this->config['ApiKeys']['result'] =>
                        [$this->config['ApiKeys']['error'] => $this->config['messages']['errorAuthReq']],
                ];
                return $this->bailOut($response, $jsonData);
            }
        }
    }
    /**
     * Returns Response object directly thereby short-circuiting the flow
     * @param Zend\Http\Response $response
     * @param array $data == data to be JSON encoded
     * @return Zend\Http\PhpEnvironment\Response
     */
    protected function bailOut($response, $data)
    {
        $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
        $response->setContent(json_encode($data));
        return $response;
    }
    /**
     * Check Request object have Authorization token or not
     * @param type $request
     * @return string $jwtToken
     */
    protected function getJwtToken($request): string
    {
        $jwtToken = $request->getHeaders("Authorization") ? $request->getHeaders("Authorization")->getFieldValue() : '';
        if ('' != $jwtToken) {
            $jwtToken = trim($jwtToken);
            return $jwtToken;
        }
        if ($request->isGet()) {
            $jwtToken = $request->getQuery('token');
        }
        if ($request->isPost()) {
            $jwtToken = $request->getPost('token');
        }
        return (string) $jwtToken;
    }
}
```
