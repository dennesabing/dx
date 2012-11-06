<?php
/**
 * BackendController
 *
 * Backend proxy to Dx ActionController
 *
 * @author Dennes <dennes.b.abing@gmail.com>
 */
namespace Dx\Mvc\Controller;

use Dx\Mvc\Controller\ActionController;

class BackendController extends ActionController
{
	protected $section = 'admin';
}