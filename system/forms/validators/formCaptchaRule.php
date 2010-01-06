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
 * formCaptionRule: правило каптчи
 *
 * @package system
 * @subpackage forms
 * @version 0.1
 */
class formCaptchaRule extends formAbstractRule
{
    protected function _validate($value)
    {
        $captcha_id = (isset($this->data[$this->field_name . '_id'])) ? $this->data[$this->field_name . '_id'] : null;

        if (!is_null($captcha_id)) {
            $toolkit = systemToolkit::getInstance();
            $session = $toolkit->getSession();

            $captchas = $session->get('mzz_captcha', array());

            if (isset($captchas[$captcha_id])) {
                $captchaValue = $captchas[$captcha_id];
                unset($captchas[$captcha_id]);
                $session->set('mzz_captcha', $captchas);

                return (md5($value) == $captchaValue);
            }
        }

        return false;
    }
}
?>