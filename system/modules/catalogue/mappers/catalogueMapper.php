<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/system/codegenerator/templates/mapper.tpl $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: mapper.tpl 1309 2007-02-13 05:54:09Z zerkms $
 */

fileLoader::load('catalogue');

/**
 * catalogueMapper: ������
 *
 * @package modules
 * @subpackage catalogue
 * @version 0.1
 */
 
class catalogueMapper extends simpleCatalogueMapper
{
    /**
     * ��� ������
     *
     * @var string
     */
    protected $name = 'catalogue';

    /**
     * ��� ������ DataObject
     *
     * @var string
     */
    protected $className = 'catalogue';

    /**
     * ���������� ���������� ��� �� ������������� ������ �� ���������� �������
     *
     * @return integer
     */
    public function convertArgsToId($args)
    {
        return 1;
    }
}

?>