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
 * Принимает 4 параметра, maxWidth и maxHeight, minWidth и minHeight,  которые могут быть заданы как вместе, так и один из них.
 *
 * @package system
 * @subpackage forms
 * @version 0.1
 */
class formImagesizeRule extends formAbstractRule
{
    public function notExists()
    {
        $this->validation = false;
    }

    protected function _validate($value, $name = null)
    {
        if (isset($_FILES[$name])) {
            try {
                $size = getimagesize($_FILES[$name]['tmp_name']);
            } catch (phpErrorException $e) {
                return false;
            }

            if (isset($this->params['maxWidth']) && $size[0] > $this->params['maxWidth']) {
                return false;
            }
            if (isset($this->params['minWidth']) && $size[0] < $this->params['minWidth']) {
                return false;
            }
            if (isset($this->params['maxHeight']) && $size[1] > $this->params['maxHeight']) {
                return false;
            }
            if (isset($this->params['minHeight']) && $size[1] < $this->params['minHeight']) {
                return false;
            }
            return true;
        }

        return false;
    }
}

?>