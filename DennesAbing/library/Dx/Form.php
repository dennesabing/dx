<?php

/**
 * Form Manager - Proxy to Zend Form
 *
 * @author Dennes B Abing <dennes.b.abing@gmail.com>
 * @package Dx
 * @subpackage Form
 * @link http://labs.madayaw.com
 */

namespace Dx;

use Zend\Form\Form as ZendForm;

class Form extends ZendForm
{
	/**
	 * Elements from XML
	 * @param type $xmlFile
	 * @return type 
	 */
	public function elementsFromXml($xmlFile)
	{
		return;
	}
}
