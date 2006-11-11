<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @package modules
 * @subpackage simple
 * @version $Id$
*/

/**
 * simpleJipRefreshView: стандартный вид для обновления открытого окна
 * или перенаправление на другой URL, если он передан в конструктор
 *
 * @package modules
 * @subpackage simple
 * @version 0.1
 */
class simpleJipRefreshView extends simpleView
{
    public function toString()
    {
        $html = '<script type="text/javascript">';
        if ($this->DAO) {
            $html .= 'window.location = "' . $this->DAO . '";';
        } else {
            $html .= 'window.location.reload();';
        }
        $html .= '</script> Обновление главного окна...';
        return $html;
    }

}

?>