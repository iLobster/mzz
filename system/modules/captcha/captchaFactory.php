<?php
/**
 * $URL: http://svn.sandbox/repository/mzz/system/modules/captcha/captchaFactory.php $
 *
 * MZZ Content Management System (c) 2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: captchaFactory.php 1121 2007-11-30 04:31:39Z zerkms $
 */

/**
 * captchaFactory: фабрика для получения контроллеров captcha
 *
 * @package modules
 * @subpackage captcha
 * @version 0.1
 */

class captchaFactory extends simpleFactory
{
    /**
     * Имя модуля
     *
     * @var string
     */
    protected $name = "captcha";
}

?>