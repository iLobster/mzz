<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
*/

/**
 * commentsMapper: ������
 *
 * @package modules
 * @subpackage comments
 * @version 0.1
 */

fileLoader::load('comments');

class commentsMapper extends simpleMapper
{
    /**
     * ��� ������
     *
     * @var string
     */
    protected $name = 'comments';

    /**
     * ��� ������ DataObject
     *
     * @var string
     */
    protected $className = 'comments';

    /**
     * ���������� ���������� ��� �� ������������� ������ �� ���������� �������
     *
     * @return object
     */
    public function convertArgsToId($args)
    {

    }
}

?>