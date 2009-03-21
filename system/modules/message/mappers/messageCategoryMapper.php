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
 * messageCategoryMapper: маппер
 *
 * @package modules
 * @subpackage message
 * @version 0.1
 */

class messageCategoryMapper extends mapper
{
    /**
     * Имя класса
     *
     * @var string
     */
    protected $class = 'messageCategory';

    /**
     * Имя таблицы
     *
     * @var string
     */
    protected $table = 'message_messageCategory';
    protected $map = array(
        'id' => array(
            'accessor' => 'getId',
            'mutator' => 'setId',
            'options' => array(
                'once', 'pk'
            )
        ),
        'title' => array(
            'accessor' => 'getTitle',
            'mutator' => 'setTitle',
        ),
        'name' => array(
            'accessor' => 'getName',
            'mutator' => 'setName',
        ),
    );

    public function convertArgsToObj($args)
    {
        $obj = $this->create();
        $obj->import(array('obj_id' => 1));
        return $obj;
    }
}

?>