<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

fileLoader::load('message/messageCategory');

/**
 * messageCategoryMapper: ������
 *
 * @package modules
 * @subpackage message
 * @version 0.1
 */

class messageCategoryMapper extends simpleMapper
{
    /**
     * ��� ������
     *
     * @var string
     */
    protected $name = 'message';

    /**
     * ��� ������ DataObject
     *
     * @var string
     */
    protected $className = 'messageCategory';

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