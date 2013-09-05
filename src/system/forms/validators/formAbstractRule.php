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

    protected $field_name;

    protected $message = '';

    public function __construct($message = '', $params = null)
    {
        //because empty array() = false and some rules may be broken
        //if ($params) {
            $this->params = $params;
        //}

        if ($message) {
            // Try to translate with i18n
            if (i18n::isName($message)) {
                $message = i18n::getMessage(i18n::extractName($message));
            }
            
            $this->message = $message;
        }
    }

    public function setData($data)
    {
        $this->data = $data;
    }

     public function setFieldName($field_name)
    {
        $this->field_name = $field_name;
    }

    public function notExists()
    {
        $this->notExists = true;
    }

    public function validate($value = null, $name = null)
    {
        if ($this->notExists) {
            return true;
        }

        $this->validation = $this->_validate($value, $name);

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