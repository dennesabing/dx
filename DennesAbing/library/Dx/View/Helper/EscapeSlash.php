<?php
/**
 * Config
 * 
 * Get the config
 *  
 */
namespace Dx\View\Helper;

use Dx\View\AbstractHelper;

class EscapeSlash extends AbstractHelper
{
    public function __invoke($str)
    {
        return $str;
    }
}
