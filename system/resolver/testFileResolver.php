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
 * testFileResolver: резолвит файлы из папки с тестами
 *
 * @package system
 * @subpackage resolver
 * @version 0.1.1
 */
class testFileResolver extends fileResolver
{
    /**
     * конструктор
     *
     */
    public function __construct()
    {
        parent::__construct(systemConfig::$pathToTests  . '/*');
    }
}

?>