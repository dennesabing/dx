<?php

namespace Dx\Doctrine\Mapping\Driver;

use Dx\Doctrine\Mapping\Driver;

/**
 * Annotation driver interface, provides method
 * to set custom annotation reader.
 * 
 * @author Dennes B Abing <dennes.b.abing@gmail.com>
 * @package Dx.Doctrine.Mapping.Driver
 * @subpackage AnnotationDriverInterface
 * @link http://labs.madayaw.com
 * 
 */
interface AnnotationDriverInterface extends Driver
{
    /**
     * Set annotation reader class
     * since older doctrine versions do not provide an interface
     * it must provide these methods:
     *     getClassAnnotations([reflectionClass])
     *     getClassAnnotation([reflectionClass], [name])
     *     getPropertyAnnotations([reflectionProperty])
     *     getPropertyAnnotation([reflectionProperty], [name])
     *
     * @param object $reader - annotation reader class
     */
    public function setAnnotationReader($reader);
}