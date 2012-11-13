<?php

/**
 * Form InputFilter - Proxy to Zend Form Inputfilter
 *
 * @author Dennes B Abing <dennes.b.abing@gmail.com>
 * @package Dx
 * @subpackage Form
 * @link http://labs.madayaw.com
 */

namespace Dx\Form;

use Zend\InputFilter\InputFilter as ZendInputFilter;

class InputFilter extends ZendInputFilter
{

	/**
	 * The Module Options
	 * @var array
	 */
	protected $moduleOptions = array();

	/**
	 * Array or XML Filename that has the form information
	 * @var string|array
	 */
	protected $xmlForm = NULL;

	public function setModuleOptions($moduleOptions)
	{
		$this->moduleOptions = $moduleOptions;
		return $this;
	}

	/**
	 * Return the Module Options
	 * @return array
	 */
	public function getModuleOptions()
	{
		return $this->moduleOptions;
	}

	/**
	 * Set the XML Form filename or array
	 * @param string|array $xmlForm Array of Form information or XML Filename
	 * @return \Dx\Form 
	 */
	public function setXml($xmlForm)
	{
		$this->xmlForm = $xmlForm;
		return $this;
	}

	/**
	 * Get the XML Filename or Array
	 * @return string|array
	 */
	public function getXml()
	{
		return $this->xmlForm;
	}

	/**
	 * Form Setup from XML
	 * @param string|array $xmlFile
	 * @return type 
	 */
	public function filterFromXml($xml = NULL)
	{
		if (!empty($xml))
		{
			$this->setXml($xml);
		}
		$xml = $this->getXml();
		if (!is_array($xml))
		{
			$xml = \Dx\Reader\Xml::toArray($xml);
		}

		if ($xml && is_array($xml) && !empty($xml))
		{
			if (isset($xml['fieldset']) && !empty($xml['fieldset']))
			{
				foreach ($xml as $f)
				{
					$filter = new InputFilter();
					$this->add($filter);
				}
			}
			else
			{
				foreach ($xml as $f)
				{
					$this->add($f);
				}
			}
		}
	}

}
