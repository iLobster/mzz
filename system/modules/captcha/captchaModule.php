<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2009
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * captchaModule
 *
 * @package modules
 * @subpackage captcha
 * @version 0.0.1
 */
class captchaModule extends simpleModule
{
    protected $classes = array(
        'captcha');

    public function getRoutes()
    {
        return array(
            array(),
            array(
                'captcha' => new requestRoute('captcha', array(
                    'module' => 'captcha',
                    'action' => 'view'))));
    }
}
?>