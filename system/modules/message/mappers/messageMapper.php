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
fileLoader::load('orm/plugins/acl_extPlugin');
fileLoader::load('orm/plugins/jipPlugin');

/**
 * messageMapper: маппер
 *
 * @package modules
 * @subpackage message
 * @version 0.1
 */

class messageMapper extends mapper
{
    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $class = 'message';
    protected $table = 'message_message';

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
        'text' => array(
            'accessor' => 'getText',
            'mutator' => 'setText',
        ),
        'sender' => array(
            'accessor' => 'getSender',
            'mutator' => 'setSender',
            'relation' => 'one',
            'foreign_key' => 'id',
            'mapper' => 'user/userMapper'
        ),
        'recipient' => array(
            'accessor' => 'getRecipient',
            'mutator' => 'setRecipient',
            'relation' => 'one',
            'foreign_key' => 'id',
            'mapper' => 'user/userMapper'
        ),
        'time' => array(
            'accessor' => 'getTime',
            'mutator' => 'setTime',
        ),
        'watched' => array(
            'accessor' => 'getWatched',
            'mutator' => 'setWatched',
        ),
        'category_id' => array(
            'accessor' => 'getCategory',
            'mutator' => 'setCategory',
            'relation' => 'one',
            'foreign_key' => 'id',
            'mapper' => 'message/messageCategoryMapper',
        ),
    );

    public function __construct()
    {
        parent::__construct();
        $this->attach(new acl_extPlugin(), 'acl');
        $this->attach(new jipPlugin(), 'jip');
    }

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
        $message = $this->searchByKey($args['id']);
        if ($message) {
            return $message;
        }

        throw new mzzDONotFoundException();
    }
}

?>