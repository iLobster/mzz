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

class formValidator
{
    private $validators;
    private $errors;

    public function __construct()
    {
        $this->errors = new arrayDataspace();
    }

    public function add($validator, $name, $errorMsg = '')
    {
        $validatorName = 'form' . ucfirst($validator) . 'Rule';
        $this->validators[] = new $validatorName($name, $errorMsg);
    }

    public function validate()
    {
        $valid = true;

        foreach ($this->validators as $validator) {
            $result = $validator->validate();

            if (!$result && !$this->errors->exists($validator->getName())) {
                $this->errors->set($validator->getName(), $validator->getErrorMsg());
            }

            $valid &= $result;
        }

        return (bool)$valid;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}

?>




