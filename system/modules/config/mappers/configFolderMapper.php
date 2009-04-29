<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2009
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

fileLoader::load('config/configFolder');

/**
 * configFolderMapper: маппер
 *
 * @package modules
 * @subpackage config
 * @version 0.3
 */
class configFolderMapper extends mapper
{
    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $class = 'configFolder';
    protected $table = 'sys_modules';

    protected $map = array(
        'id' => array(
            'accessor' => 'getId',
            'mutator' => 'setId',
            'options' => array('pk','once')
         ),
        'name' => array(
            'accessor' => 'getName',
            'mutator' => 'setName',
            'options' => array('once'),
        ),
        'title' => array(
            'accessor' => 'getTitle',
            'mutator' => 'setTitle',
            'options' => array('once'),
        ),
        'options' => array(
            'accessor' => 'getOptions',
            'mutator' => 'setOptions',
            'relation' => 'many',
            'mapper' => 'config/configOptionMapper',
            'foreign_key' => 'module_name',
            'local_key' => 'name'
        )
    );

    public function searchById($id)
    {
        return $this->searchByKey($id);
    }

    public function searchByName($name)
    {
        return $this->searchOneByField('name', $name);
    }

    public static function getTypes()
    {
        return array(
            configOption::TYPE_INT => 'число',
            configOption::TYPE_STRING => 'строка',
            configOption::TYPE_BOOL => 'bool',
            configOption::TYPE_LIST => 'варианты',
        );
    }

    public function save($object, $user = null)
    {
    }

    /**
     * Возвращает доменный объект по аргументам
     *
     * @return simple
     */
    public function convertArgsToObj($args)
    {
        $obj = $this->create();
        return $obj;
    }
}

?>