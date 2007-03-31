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

class formValidate
{
    protected $validators;

    public function __construct()
    {
    }

    public function addValidator($validator, $break = false)
    {
        $this->validators[] = array('validator' => $validator, 'break' => (bool)$break);
    }

    public function validate($value)
    {
        $result = true;
        foreach ($this->validators as $validator) {
            if ($validator['validator']->isValid($value)) {
                continue;
            }
            $result = false;
            if ($validator['break']) {
                break;
            }
        }
        return $result;
    }
}
?>




