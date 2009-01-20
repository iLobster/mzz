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
 * formImagesizeRule: валидатор размеров (ширина/высота) загружаемых изображений
 * Имеет два параметра, maxWidth и maxHeight, которые могут быть заданы как вместе, так и один из них.
 *
 * @package system
 * @subpackage forms
 * @version 0.1
 */
class formImagesizeRule extends formAbstractRule
{
    public function validate()
    {
        if (isset($_FILES[$this->name])) {
            try {
                $size = getimagesize($_FILES[$this->name]['tmp_name']);
            } catch (phpErrorException $e) {
                return false;
            }
            if (isset($this->params['maxWidth']) && $size[0] > $this->params['maxWidth']) {
                return false;
            }
            if (isset($this->params['maxHeight']) && $size[1] > $this->params['maxHeight']) {
                return false;
            }
            return true;
        }

        return false;
    }
}

?>