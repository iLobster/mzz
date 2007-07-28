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
 * messageMapper: маппер
 *
 * @package modules
 * @subpackage message
 * @version 0.1
 */

class messageMapper extends simpleMapper
{
    /**
     * Имя модуля
     *
     * @var string
     */
    protected $name = 'message';

    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $className = 'message';

    /**
     * Выполнение операций с массивом $fields перед обновлением в БД
     *
     * @param array $fields
     */
    protected function updateDataModify(&$fields)
    {
        $fields['time'] = new sqlFunction('UNIX_TIMESTAMP');
    }

    /**
     * Выполнение операций с массивом $fields перед вставкой в БД
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