<?php

namespace Dx\Doctrine\Mapping\Driver;

use Dx\Doctrine\Mapping\Driver;

/**
 * The chain mapping driver enables chained
 * extension mapping driver support
 *
 * @author Dennes B Abing <dennes.b.abing@gmail.com>
 * @package Dx.Doctrine.Mapping.Driver
 * @subpackage Chain
 * @link http://labs.madayaw.com
 * 
 */
class Chain implements Driver
{
    /**
     * List of drivers nested
     * @var array
     */
    private $_drivers = array();

    /**
     * Add a nested driver.
     *
     * @param Driver $nestedDriver
     * @param string $namespace
     */
    public function addDriver(Driver $nestedDriver, $namespace)
    {
        $this->_drivers[$namespace] = $nestedDriver;
    }

    /**
     * Get the array of nested drivers.
     *
     * @return array $drivers
     */
    public function getDrivers()
    {
        return $this->_drivers;
    }

    /**
     * {@inheritDoc}
     */
    public function readExtendedMetadata($meta, array &$config)
    {
        foreach ($this->_drivers as $namespace => $driver) {
            if (strpos($meta->name, $namespace) === 0) {
                $driver->readExtendedMetadata($meta, $config);
                return;
            }
        }
        // commenting it for customized mapping support, debugging of such cases might get harder
        //throw new \Gedmo\Exception\UnexpectedValueException('Class ' . $meta->name . ' is not a valid entity or mapped super class.');
    }

    /**
     * Passes in the mapping read by original driver
     *
     * @param $driver
     * @return void
     */
    public function setOriginalDriver($driver)
    {
        //not needed here
    }
}