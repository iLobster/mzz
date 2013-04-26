<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/forms/validators/formUploadedRule.php $
 *
 * MZZ Content Management System (c) 2005-2009
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: formUploadedRule.php 2182 2007-11-30 04:41:35Z zerkms $
 */

/**
 * formFilesizeRule: валидатор размера загружаемых файлов
 *
 * @package system
 * @subpackage forms
 * @version 0.1
 */
class formFilesizeRule extends formAbstractRule
{
    public function notExists()
    {
        $this->validation = false;
    }

    protected function _validate($value, $name = null)
    {
        if (!isset($_FILES[$name])) {
            return true;
        }

        if (!isset($this->params)) {
            throw new mzzRuntimeException('Argument with fileManager folder or size in bytes expected');
        }

        if ($this->params instanceof folder) {
            $size = $this->params->getFilesize() * 1024 * 1024;
            if (!$size) {
                return true;
            }
        } else {
            $size = $this->params;
        }

        return $_FILES[$name]['size'] <= $size;
    }
}

?>