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
 * mzzRuntimeException
 *
 * @package system
 * @subpackage exceptions
 * @version 0.1
*/
class mzzRuntimeException extends mzzException
{

    /**
     * Конструктор
     *
     * @param string $message
     * @param integer $code
     */
    public function __construct($message, $code = 0)
    {
        parent::__construct($message, $code);
        $this->setName('Runtime Exception');
    }
}

?>