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
 * formCsrfRule: правило проверки уникального идентификатора формы для защиты от CSRF аттак
 *
 * @package system
 * @subpackage forms
 * @version 0.1
 */
class formCsrfRule extends formAbstractRule
{
    protected $message = 'CSRF verification error. Try again';

    protected function _validate($value)
    {
        $session = systemToolkit::getInstance()->getSession();
        return $session->get('CSRFToken') === $value;
    }
}

?>