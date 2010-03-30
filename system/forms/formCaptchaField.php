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
    public function render($attributes = array(), $value = null)
    {
        $captcha_id = md5(microtime(true));

        $tplPrefix = isset($attributes['tplPrefix']) ? $attributes['tplPrefix'] : '';

        $view = systemToolkit::getInstance()->getView('smarty');
        $view->assign('captcha_id', $captcha_id);
        $view->assign('attributes', $attributes);

        return $view->render('captcha/' . $tplPrefix . 'captcha.tpl');
    }
}

?>