<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/system/forms/formCaptchaField.php $
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: formCaptchaField.php 1866 2007-07-05 05:07:45Z zerkms $
 */

/**
 * formCaptchaField: captcha
 *
 * @package system
 * @subpackage forms
 * @version 0.1
 */
class formCaptchaField extends formElement
{
    static public function toString($options = array())
    {
        //$options['type'] = 'text';

        $image = self::createTag(array('src' => '/captcha/?rand=' . mt_rand(0, 10000)), 'img');

        return $image . self::createTag($options);
    }
}

?>