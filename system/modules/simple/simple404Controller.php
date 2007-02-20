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
 * simple404Controller: контроллер для метода 404 модуля simple
 *
 * @package modules
 * @subpackage simple
 * @version 0.1
 */

class simple404Controller extends simpleController
{
    public function getView()
    {
        return 'Запрашиваемая вами страница не найдена';
    }
}

?>