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
 * mzzIoException
 *
 * @package system
 * @subpackage exceptions
 * @version 0.1
*/
class mzzIoException extends mzzException
{
    /**
     * �����������
     *
     * @param string $filename ��� �����
     */
    public function __construct($filename)
    {
        $message = '���� �� ������: <i>' . $filename . '</i>';
        parent::__construct($message);
        $this->setName('IO Exception');
    }
}

?>