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

fileLoader::load('message');

/**
 * messageMapper: ������
 *
 * @package modules
 * @subpackage message
 * @version 0.1
 */

class messageMapper extends simpleMapper
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
    protected $className = 'message';

    /**
     * ���������� �������� � �������� $fields ����� ����������� � ��
     *
     * @param array $fields
     */
    protected function updateDataModify(&$fields)
    {
        $fields['time'] = new sqlFunction('UNIX_TIMESTAMP');
    }

    /**
     * ���������� �������� � �������� $fields ����� �������� � ��
     *
     * @param array $fields
     */
    protected function insertDataModify(&$fields)
    {
        $this->updateDataModify($fields);
    }

    public function convertArgsToObj($args)
    {
        return $this->searchByKey($args['id']);
    }
}

?>