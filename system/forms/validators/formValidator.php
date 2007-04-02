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

    public function add($validator, $value)
    {
        $validatorName = 'form' . ucfirst($validator) . 'Rule';
        $this->validators[] = new $validatorName($value);
    }

    public function validate()
    {
        $valid = true;

        foreach ($this->validators as $validator) {
            $valid &= $validator->validate();
        }

        return $valid;
    }


}

?>




