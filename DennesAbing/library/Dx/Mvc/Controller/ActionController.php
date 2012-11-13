<?php

namespace Dx\Mvc\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Renderer\PhpRenderer;
use Doctrine\ORM\EntityManager;

class ActionController extends AbstractActionController
{

	/**
	 * Section of the site e.g. admin or back, front
	 * @var type string
	 */
	protected $section = NULL;

	/**
	 * @var Doctrine\ORM\EntityManager
	 */
	protected $em;

	/**
	 * The Option Object
	 * @var object
	 */
	protected $options;

	/**
	 * The module Prefix
	 * @var string
	 */
	protected $modulePrefix = NULL;

	/**
	 * The View
	 * @var type
	 */
	protected $view = NULL;

	public function init()
	{
		parent::init();
	}

	public function setEntityManager(EntityManager $em)
	{
		$this->em = $em;
	}

	public function getEntityManager()
	{
		if (NULL === $this->em)
		{
			$this->setEntityManager($this->getServiceLocator()->get('Doctrine\ORM\EntityManager'));
		}
		return $this->em;
	}

	/**
	 * Return a ViewModel
	 * @param type $variables
	 * @param type $options
	 * @return \Zend\View\Model\ViewModel
	 */
	public function getViewModel($variables = NULL, $options = NULL)
	{
		if (empty($this->view))
		{
			$this->view = new ViewModel($variables, $options);
		}
		return $this->view;
	}

	/**
	 * NOT USED
	 * Proxy to getViewModel
	 * @param type $variables
	 * @param type $options
	 * @return type
	 */
	public function getView()
	{
		return $this->view;
	}

	/**
	 * Get the Posted information
	 * @return type associated array of POST
	 */
	public function getPost()
	{
		$request = $this->getRequest();
		return $request->getPost();
	}

	/**
	 * Check if Request is POST
	 * @return type boolean TRUE if post
	 */
	public function isPost()
	{
		$request = $this->getRequest();
		return $request->isPost();
	}

	/**
	 * Check for Cache Existence in a File
	 * @param type $key
	 * @param type $options
	 * @return boolean 
	 */
	public function hasCacheFromFile($key, $options = array())
	{
		$cache = $this->getServiceLocator()->get('dx_cache')->getFileCache()->setOptions($options);
		$key = \Dx\Cache::name($key);
		if ($cache->hasItem($key))
		{
			return $cache->getItem($key);
		}
		return FALSE;
	}

	/**
	 * Check for cache existence in Memory
	 * @param type $key
	 * @param type $options
	 * @return boolean 
	 */
	public function hasCacheFromMemory($key, $options = array())
	{
		$cache = $this->getServiceLocator()->get('dx_cache')->getMemoryCache()->setOptions($options);
		$key = \Dx\Cache::name($key);
		if ($cache->hasItem($key))
		{
			return $cache->getItem($key);
		}
		return FALSE;
	}

	/**
	 * Cache $data with $key to Cache\Filesystem
	 * @param type $key
	 * @param type $data
	 * @param type $options
	 * @return type 
	 */
	public function cacheToFile($key, $data, $options = array())
	{
		$cache = $this->getServiceLocator()->get('dx_cache')->getFileCache()->setOptions($options);
		$key = \Dx\Cache::name($key);
		return $cache->setItem($key, $data);
	}

	/**
	 * Cache $data with $key to Cache\Memcache
	 * @param type $key
	 * @param type $data
	 * @param type $options
	 * @return type 
	 */
	public function cacheToMemory($key, $data, $options = array())
	{
		$cache = $this->getServiceLocator()->get('dx_cache')->getMemoryCache()->setOptions($options);
		$key = \Dx\Cache::name($key);
		return $cache->setItem($key, $data);
	}

	/**
	 * Cache a File data
	 * @param type $key
	 * @param type $data
	 * @param type $options
	 * @return mixed
	 */
	public function cacheAFile($key, $data, $options = array())
	{
		$cache = $this->getServiceLocator()->get('dx_cache')->getFileCache()->setOptions($options);
		$key = \Dx\Cache::name($key);
		return $cache->setItem($key, $data);
	}

	/**
	 * Cache an Ojbect Data
	 * @param type $key
	 * @param type $data
	 * @param type $options
	 * @return object
	 */
	public function cacheAnObject($key, $data, $options = array())
	{
		$cache = $this->getServiceLocator()->get('dx_cache')->getFileCache()->setOptions($options);
		$key = \Dx\Cache::name($key);
		return $cache->setItem($key, $data);
	}

	/**
	 * CAche an Array Data
	 * @param type $key
	 * @param type $data
	 * @param type $options
	 * @return array 
	 */
	public function cacheAnArray($key, $data, $options = array())
	{
		$cache = $this->getServiceLocator()->get('dx_cache')->getFileCache()->setOptions($options);
		$key = \Dx\Cache::name($key);
		return $cache->setItem($key, $data);
	}

	/**
	 * Get Module Options
	 * @see Module.php
	 *
	 * @return Options
	 */
	public function getOptions()
	{
		$this->setOptions($this->getServiceLocator()->get($this->modulePrefix . '_options'));
		return $this->options;
	}

	/**
	 * Set Module Options
	 *
	 * @param AbstractOptions $options
	 * @return $this
	 */
	public function setOptions($options)
	{
		$this->options = $options;
		return $this;
	}

	/**
	 * Return the session
	 * @return \Zend\Session\Container;
	 */
	public function getSession()
	{
		return $this->getServiceLocator()->get($this->modulePrefix . '_session');
	}
	
}