<?php

namespace Dx\PHPUnit;

use PHPUnit_Framework_TestCase;
use Zend\Mvc\MvcEvent;

class BaseTestCase extends PHPUnit_Framework_TestCase
{

	/**
	 * Doctrine ORM EntityManager
	 * @var type 
	 */
	protected $entityManager = NULL;
	protected $em = NULL;

	/**
	 * The application
	 *
	 * @var \Zend\Mvc\Application
	 */
	protected $application;

	/**
	 * Whether or not a test request has been dispatched.
	 *
	 * @var boolean
	 */
	protected $dispatched = false;

	/**
	 * The response of the most recent dispatch.
	 *
	 * @var \Zend\Http\PhpEnvironment\Response
	 */
	protected $response;

	/**
	 * The request for the most recent dispatch.
	 *
	 * @var \Zend\Http\PhpEnvironment\Request
	 */
	protected $request;

	/**
	 * The matched route of the most recent dispatch.
	 *
	 * @var \Zend\Mvc\Router\Http\RouteMatch
	 */
	protected $routeMatch;

	/**
	 * The ViewModel returned by the controller in the most recent dispatch.
	 *
	 * @var \Zend\View\Model\ViewModel
	 */
	protected $viewModel;
	
	/**
	 * Drop Tables on tearDown
	 * @var boolean
	 */
	protected $dropDb = TRUE;

	/**
	 * Entities to be used for this Test 
	 */
	protected $entities = array();
	protected $doctrineEntities = array();

	public function setUp()
	{
		parent::setUp();
		$this->application = \Zend\Mvc\Application::init(include TEST_APP_ROOT . '/config/application.config.php');
		$this->em = $this->application->getServiceManager()->get('doctrine.entitymanager.orm_default');
		$this->request = null;
		$this->response = null;
		$this->routeMatch = null;
		$this->viewModel = null;

		if (!empty($this->entities))
		{
			$tool = new \Doctrine\ORM\Tools\SchemaTool($this->em);
			foreach ($this->entities as $entity)
			{
				$this->doctrineEntities[] = $this->em->getClassMetadata($entity);
			}
			$tool->dropSchema($this->doctrineEntities);
			$tool->createSchema($this->doctrineEntities);
			$this->em->getConfiguration()->getResultCacheImpl()->flushAll();
			$this->em->getConfiguration()->getResultCacheImpl()->deleteAll();
		}
	}
	
	public function getServiceManager()
	{
		return $this->application->getServiceManager();
	}

	public function tearDown()
	{
		if (!empty($this->doctrineEntities))
		{
			$tool = new \Doctrine\ORM\Tools\SchemaTool($this->em);
			if($this->dropDb)
			{
				$tool->dropSchema($this->doctrineEntities);
			}
			$this->em->getConfiguration()->getResultCacheImpl()->flushAll();
			$this->em->getConfiguration()->getResultCacheImpl()->deleteAll();
		}
		parent::tearDown();
	}

	/**
	 * Asserts that the most recent dispatch arrived at the specified action.
	 *
	 * @param  string $action   The action.
	 * @param  string $message  (Optional) The message to output on failure.
	 */
	public function assertAction($action, $message = '')
	{
		$actualAction = !empty($this->routeMatch) ? $this->routeMatch->getParam('action') : null;
		$this->assertSame($action, $actualAction, $message);
	}

	/**
	 * Asserts that the most recent dispatch arrived at the specified controller.
	 *
	 * @param  string $controller The controller.
	 * @param  string $message    (Optional) The message to output on failure.
	 */
	public function assertController($controller, $message = '')
	{
		$actualController = !empty($this->routeMatch) ? $this->routeMatch->getParam('controller') : null;
		$this->assertSame($controller, $actualController, $message);
	}

	/**
	 * Asserts that the most recent dispatch did not arrive at the specified action.
	 *
	 * @param  string $action   The action.
	 * @param  string $message  (Optional) The message to output on failure.
	 */
	public function assertNotAction($action, $message = '')
	{
		$actualAction = !empty($this->routeMatch) ? $this->routeMatch->getParam('action') : null;
		$this->assertNotSame($action, $actualAction, $message);
	}

	/**
	 * Asserts that the most recent dispatch did not arrive at the specified controller.
	 *
	 * @param  string $controller The controller.
	 * @param  string $message    (Optional) The message to output on failure.
	 */
	public function assertNotController($controller, $message = '')
	{
		$actualController = !empty($this->routeMatch) ? $this->routeMatch->getParam('controller') : null;
		$this->assertNotSame($controller, $actualController, $message);
	}

	/**
	 * Asserts that the provided response code does not match the one resulting from the most recent dispatch.
	 *
	 * @param  integer $code    The HTTP response code.
	 * @param  string  $message (Optional) The message to output on failure.
	 * @return void
	 */
	public function assertNotResponseCode($code, $message = '')
	{
		$responseCode = !empty($this->dispatched) ? $this->response->getStatusCode() : null;
		$this->assertNotSame($code, $responseCode, $message);
	}

	/**
	 * Asserts that the provided response code matches the one resulting from the most recent dispatch.
	 *
	 * @param  integer $code    The HTTP response code.
	 * @param  string  $message (Optional) The message to output on failure.
	 * @return void
	 */
	public function assertResponseCode($code, $message = '')
	{
		$actualCode = !empty($this->response) ? $this->response->getStatusCode() : null;
		$this->assertSame($code, $actualCode, $message);
	}

	/**
	 * Dispatches a request.
	 *
	 * @param  string $url        The URL to dispatch
	 * @param  bool   $renderView (Optional) Whether or not to render the view. Default is false
	 * @return void
	 */
	protected function dispatch($url, $renderView = false)
	{
		$event = $this->application->getMvcEvent();
		$eventManager = $this->application->getEventManager();
		$this->request = $event->getRequest();
		$this->request->setUri($url);

		$this->routeMatch = $eventManager->trigger(MvcEvent::EVENT_ROUTE, $event)->first();
		$this->viewModel = $eventManager->trigger(MVcEvent::EVENT_DISPATCH, $event)->first();
		$responseEvent = ($renderView ? MvcEvent::EVENT_RENDER : MvcEvent::EVENT_FINISH);
		$this->response = $eventManager->trigger($responseEvent, $event)->first();
	}

}