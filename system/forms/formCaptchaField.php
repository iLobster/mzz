<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
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
        $options['type'] = 'text';

        $captcha_id = md5(microtime(true));

        $url = new url('captcha');
        $captcha_src = $url->get() . '?rand=' . $captcha_id;

        $image = self::createTag(array('src' => $captcha_src, 'width' => 120, 'height' => 40, 'alt' => '������� �� ����������� ��� ����������', 'onclick' => 'javascript: this.src = "' . $captcha_src . '&refresh=" + Math.random();'), 'img');
        $hidden = self::createTag(array('type' => 'hidden', 'name' => $options['name'] . '_id', 'value' => $captcha_id), 'input');

        return $hidden . $image . '<br />' . self::createTag($options);
    }
}

?>