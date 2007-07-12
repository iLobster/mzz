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

fileLoader::load('voting/vote');

/**
 * voteMapper: ������
 *
 * @package modules
 * @subpackage vote
 * @version 0.1
 */

class voteMapper extends simpleMapper
{
    /**
     * ��� ������
     *
     * @var string
     */
    protected $name = 'voting';

    /**
     * ��� ������ DataObject
     *
     * @var string
     */
    protected $className = 'vote';

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