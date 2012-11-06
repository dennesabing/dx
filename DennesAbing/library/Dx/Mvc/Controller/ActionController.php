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
}