<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2006
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//

/**
 * mzzInvalidParameterException
 *
 * @package system
 * @version 0.1
*/
class mzzInvalidParameterException extends mzzException
{

    /**
     * Конструктор
     *
     * @param string $message
     * @param mixed $param
     * @param integer $code
     * @todo Add type-detect and echo value of $param
     */
    public function __construct($message, $param, $code = 0)
    {
        $message = $message . '[Type: ' .gettype($param) . ']';
        parent::__construct($message, $code);
        $this->setName('Invalid Parameter');
    }

}

?>