<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/system/forms/validators/formCaptchaRule.php $
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: formCaptchaRule.php 2566 2008-08-14 01:46:41Z striker $
 */

/**
 * formCsrfRule: правило проверки уникального идентификатора формы для защиты от CSRF аттак
 *
 * @package system
 * @subpackage forms
 * @version 0.1
 */
class formCsrfRule extends formAbstractRule
{
    public function validate()
    {
        $session = systemToolkit::getInstance()->getSession();
        $valid = $session->get('CSRFToken') === $this->value;
        $session->destroy('CSRFToken');
        return $valid;
    }
}

?>