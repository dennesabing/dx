<?php

namespace Dx\Doctrine\Mapping;

/**
 * The mapping driver abstract class, defines the
 * metadata extraction function common among
 * all drivers used on these extensions.
 * 
 * @author Dennes B Abing <dennes.b.abing@gmail.com>
 * @package Dx.Doctrine.Mapping
 * @subpackage Driver
 * @link http://labs.madayaw.com
 */

interface Driver
{
    /**
     * Read extended metadata configuration for
     * a single mapped class
     *
     * @param object $meta
     * @param array $config
     * @return void
     */
    public function readExtendedMetadata($meta, array &$config);

    /**
     * Passes in the original driver
     *
     * @param $driver
     * @return void
     */
    public function setOriginalDriver($driver);
}
