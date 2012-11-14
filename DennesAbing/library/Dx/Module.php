<?php
/**
 * Access to Module
 * 
 * @author Dennes B Abing <dennes.b.abing@gmail.com>
 * @package Dx
 * @subpackage Module
 * @link http://labs.madayaw.com
 */

namespace Dx;

use Zend\Mvc\ModuleRouteListener;
use Zend\Module\Manager,
	Zend\EventManager\StaticEventManager,
	Zend\EventManager\EventInterface as Event;

class Module
{

	protected $namespace = NULL;
	protected $dir = NULL;

//	public function init(\Zend\ModuleManager\ModuleManager $moduleManager)
//	{
//		$sharedEvents = $moduleManager->getEventManager()->getSharedManager();
//        $sharedEvents->attach(__NAMESPACE__, 'dispatch', function($e) {
//            $controller = $e->getTarget();
//            $controller->layout('layout/alternativelayout');
//        }, 100);
//        
// http://framework.zend.com/manual/2.0/en/modules/zend.module-manager.module-class.html
// Remember to keep the init() method as lightweight as possible
//        $events = $moduleManager->getEventManager();
//        $events->attach('loadModules.post', array($this, 'modulesLoaded')
//        loadModules.post happens when All modules are loaded
//        There should be a method here named: 'modulesLoaded'
//	}

	public function getConfig()
	{
		return include $this->dir . '/config/module.config.php';
	}

	public function getAutoloaderConfig()
	{
		return array(
			'Zend\Loader\StandardAutoloader' => array(
				'namespaces' => array(
					$this->namespace => $this->dir . '/src/' . $this->namespace,
				),
			),
		);
	}

	/**
	 * Return the module default configuration 
	 * for module.config.php
	 * 
	 * @param $module the camelcased module name 
	 * @param $options array Some options to overwrite
	 */
	public static function defaultConfig($module, $path, $options = array())
	{
		$upperCased = ucfirst($module);
		$lowerCased = strtolower($module);
		$doctrineEnabled = TRUE;
		$arr = array(
			'controllers' => array(
				'invokables' => array(
					$upperCased . '\Controller\\' . $upperCased => $upperCased . '\Controller\\' . $upperCased . 'Controller',
					$upperCased . '\Controller\Admin' => $upperCased . '\Controller\AdminController',
				),
			),
			'router' => array(
				'routes' => array(
					$lowerCased => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/' . $lowerCased . '[/:action][/:id]',
							'constraints' => array(
								'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
								'id' => '[0-9]+',
							),
							'defaults' => array(
								'controller' => $upperCased . '\Controller\\' . $upperCased,
								'action' => 'index',
							),
						),
					),
					$lowerCased . 'Admin' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/admin/' . $lowerCased . '[/:action][/:id][/:sid][/:query]',
							'constraints' => array(
								'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
								'id' => '[0-9]+',
								'sid' => '[a-zA-Z][a-zA-Z0-9_-]*',
								'query' => '[a-zA-Z][a-zA-Z0-9_-]*'
							),
							'defaults' => array(
								'controller' => $upperCased . '\Controller\Admin',
								'action' => 'index',
								'section' => 'admin',
							),
						),
					),
				),
			),
			'view_manager' => array(
				'template_path_stack' => array(
					$lowerCased => $path . '/../view',
				),
			),
		);
		if ($doctrineEnabled)
		{
			$options['doctrine'] = array(
				'driver' => array(
					$upperCased . '_driver' => array(
						'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
						'cache' => 'memcache',
						'paths' => array($path . '/../src/' . $upperCased . '/Entity')
					),
					'orm_default' => array(
						'drivers' => array(
							$upperCased . '\Entity' => $upperCased . '_driver'
						)
					)
				),
			);
		}
		return \Dx\ArrayManager::merge($arr, $options);
	}

}
