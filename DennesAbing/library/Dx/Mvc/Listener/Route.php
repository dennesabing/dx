<?php

namespace Dx\Mvc\Listener;

use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\Mvc\MvcEvent;

class Route implements ListenerAggregateInterface
{

	/**
	 * @var \Zend\Stdlib\CallbackHandler[]
	 */
	protected $listeners = array();

	/**
	 * Attach to an event manager
	 *
	 * @param  EventManagerInterface $events
	 * @param  integer $priority
	 */
	public function attach(EventManagerInterface $events, $priority = 1)
	{
		$this->listeners[] = $events->attach(MvcEvent::EVENT_ROUTE, array($this, 'onRoute'), $priority);
	}

	/**
	 * Detach all our listeners from the event manager
	 *
	 * @param  EventManagerInterface $events
	 * @return void
	 */
	public function detach(EventManagerInterface $events)
	{
		foreach ($this->listeners as $index => $listener)
		{
			if ($events->detach($listener))
			{
				unset($this->listeners[$index]);
			}
		}
	}

	/**
	 * Listen to the "route" event and determine if the module namespace should
	 * be prepended to the controller name.
	 *
	 * If the route match contains a parameter key matching the MODULE_NAMESPACE
	 * constant, that value will be prepended, with a namespace separator, to
	 * the matched controller parameter.
	 *
	 * @param  MvcEvent $e
	 * @return null
	 */
	public function onRoute(MvcEvent $e)
	{
		$matches = $e->getRouteMatch();
		\Dx::setRequestParams($matches->getParams());
	}

}