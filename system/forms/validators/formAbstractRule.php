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
 * @version 0.1
 */
abstract class formAbstractRule
{
    protected $name;
    protected $value;
    protected $errorMsg;
    protected $params;

    public function __construct($name, $errorMsg = '', $params = '')
    {
        $this->name = $name;
        $this->errorMsg = $errorMsg;
        $this->params = $params;

        $request = systemToolkit::getInstance()->getRequest();
        $this->value = $request->get($name, 'string', SC_REQUEST);
    }

    abstract public function validate();

    public function getErrorMsg()
    {
        return $this->errorMsg;
    }

    public function getName()
    {
        return $this->name;
    }
}

?>