<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/template/drivers/native/urlNativePlugin.php $
 *
 * MZZ Content Management System (c) 2010
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @package system
 * @subpackage template
 * @version $Id: urlNativePlugin.php 4210 2010-04-30 05:10:01Z striker $
 */

fileLoader::load('service/bbcode');

/**
 * Native bbcode plugin
 *
 * @package system
 * @subpackage template
 * @version 0.1.0
 */
class bbcodeNativePlugin extends aNativePlugin
{
    public function run($source)
    {
        $bbcode_parser = new bbcode($source);
        return $bbcode_parser->parse();
    }
}
?>