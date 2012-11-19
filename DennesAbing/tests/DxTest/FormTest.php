<?php

namespace DxFormTest;

use Dx\Form as DxForm;

class FormTest extends \PHPUnit_Framework_TestCase
{
	
    public function setUp()
    {
    }

    /**
     * Teardown environment
     */
    public function tearDown()
    {
    }	
	
	public function testFormFromXmlAction()
	{
		$xmlForm = realpath(dirname(__DIR__)) . '/data/formxml.xml';
		$form = new DxForm();
		$form->formFromXml($xmlForm);
		$this->assertTrue(file_exists($xmlForm));
		$this->assertEquals('FormName', $form->getName());
		
		/**
		 * Check for element or fieldset 
		 */
		$this->assertTrue($form->has('select'));
		
		/**
		 * Check for element or fieldset was remove 
		 */
		$this->assertFalse($form->has('selectToBeRemove'));
	}
}
