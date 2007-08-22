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

fileLoader::load('forum/post');

/**
 * postMapper: ������
 *
 * @package modules
 * @subpackage forum
 * @version 0.1
 */

class postMapper extends simpleMapper
{
    /**
     * ��� ������
     *
     * @var string
     */
    protected $name = 'forum';

    /**
     * ��� ������ DataObject
     *
     * @var string
     */
    protected $className = 'post';

    /**
     * ���������� �������� ������ �� ����������
     *
     * @return simple
     */
    public function convertArgsToObj($args)
    {
        throw new mzzDONotFoundException();
    }
}

?>