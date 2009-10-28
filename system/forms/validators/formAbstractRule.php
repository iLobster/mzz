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
 * formAbstractRule
 *
 * @package system
 * @subpackage forms
 * @version 0.1.3
 */
abstract class formAbstractRule
{
    protected $notExists = false;

    protected $validation = null;

    protected $params;

    protected $data = array();

    protected $message = '';

    public function __construct($message = '', $params = null)
    {
        if ($params) {
            $this->params = $params;
        }

        if ($message) {
            $this->message = $message;
        }
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function notExists()
    {
        $this->notExists = true;
    }

    public function validate($value = null)
    {
        if ($this->notExists) {
            return true;
        }

        $this->validation = $this->_validate($value);

        return $this->validation;
    }

    abstract protected function _validate($value);

    public function getErrorMsg()
    {
        if ($this->validation === false) {
            return $this->message;
        }
    }
}

?>