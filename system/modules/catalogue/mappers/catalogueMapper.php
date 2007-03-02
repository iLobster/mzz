<?php
/**
 * $URL: http://svn.web/repository/mzz/system/modules/catalogue/mappers/catalogueMapper.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: catalogueMapper.php 637 2007-03-02 03:07:52Z zerkms $
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