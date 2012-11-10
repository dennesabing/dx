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
	 * Form Setup from XML
	 * @param type $xmlFile
	 * @return type 
	 */
	public function formFromXml($xmlFile)
	{
		$xml = \Dx\Reader\Xml::toArray($xmlFile);
		$fieldsets = array();
		$elements = array();
		if ($xml && is_array($xml))
		{
			if (isset($xml['form']['name']))
			{
				$this->setName($xml['form']['name']);
			}
			if (isset($xml['form']['attributes']))
			{
				foreach ($xml['form']['attributes'] as $key => $val)
				{
					$this->setAttribute($key, $val);
				}
			}
			if (isset($xml['form']['fieldset']) && !empty($xml['form']['fieldset']))
			{
				foreach ($xml['form']['fieldset'] as $fs)
				{
					if(isset($fs['name']))
					{
						$fieldsets = $this->orderElement($fieldsets, $fs);
					}
				}
			}
			if (isset($xml['form']['element']) && !empty($xml['form']['element']))
			{
				foreach ($xml['form']['element'] as $ele)
				{
					if(isset($ele['fieldset']) && !empty($ele['fieldset']))
					{
						$fieldsets = $this->orderElement($fieldsets[$ele['fieldset']], $ele);
					}
					else 
					{
						if(isset($ele['name']))
						{
							$elements = $this->orderElement($elements, $ele);
						}
					}
				}
			}
		}
		
		if(!empty($fieldsets))
		{
			foreach($fieldsets as $name => $fs)
			{
				$this->add($fs);
			}
		}
		if(!empty($elements))
		{
			foreach($elements as $name => $ele)
			{
				$this->add($ele);
			}
		}
	}
	
	
	/**
	 * Position an Element
	 * @param array $elements Array of Elements
	 * @param array $ele The Element to insert
	 * @return array The new Array of Elements
	 */
	public function orderElement($elements, $ele)
	{
		$positions = array('after', 'before');
		foreach($positions as $pos)
		{
			if(isset($ele[$pos]))
			{
				if(isset($elements[$ele[$pos]]))
				{
					$keyPos = $ele[$pos];
					unset($ele[$pos]);
					$elements = \Dx\ArrayManager::array_insert($elements, $keyPos, array($ele['name'] => $ele), $pos);
					return $elements;
				}
			}
		}
		$elements[$ele['name']] = $ele;
		return $elements;
	}
}
