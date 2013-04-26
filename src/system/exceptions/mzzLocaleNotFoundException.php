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
 * @package system
 * @subpackage exceptions
 * @version $Id$
*/

/**
 * mzzLocaleNotFoundException
 *
 * @package system
 * @subpackage exceptions
 * @version 0.1
*/
class mzzLocaleNotFoundException extends mzzException
{
    /**
     * Конструктор
     *
     * @param string $filename имя файла
     */
    public function __construct($name)
    {
        $message = 'The locale for <i>' . $name . '</i> not found';
        parent::__construct($message);
        $this->setName('Locale not found exception');
    }
}

?>