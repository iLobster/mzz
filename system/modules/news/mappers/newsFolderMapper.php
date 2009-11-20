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

fileLoader::load('news/model/newsFolder');
fileLoader::load('orm/plugins/tree_mpPlugin');
fileLoader::load('modules/jip/plugins/jipPlugin');
fileLoader::load('modules/i18n/plugins/i18nPlugin');

/**
 * newsFolderMapper: маппер для папок новостей
 *
 * @package modules
 * @subpackage news
 * @version 0.3.1
 */
class newsFolderMapper extends mapper
{
    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $class = 'newsFolder';
    protected $table = 'news_newsFolder';

    protected $map = array(
        'id' => array(
            'accessor' => 'getId',
            'mutator' => 'setId',
            'options' => array(
                'pk',
                'once')),
        'name' => array(
            'accessor' => 'getName',
            'mutator' => 'setName'),
        'title' => array(
            'accessor' => 'getTitle',
            'mutator' => 'setTitle',
            'options' => array(
                'i18n')),
        'items' => array(
            'accessor' => 'getItems',
            'mutator' => 'setItems',
            'relation' => 'many',
            'mapper' => 'news/news',
            'foreign_key' => 'folder_id',
            'local_key' => 'id'
        )
    );

    public function __construct()
    {
        parent::__construct();
        $this->attach(new tree_mpPlugin(array(
            'path_name' => 'name')), 'tree');
        $this->plugins('jip');
        $this->plugins('i18n');
    }

    public function searchByParentId($id)
    {
        return $this->searchOneByField('parent', $id);
    }

    /**
     * Выполняет поиск объекта по имени
     *
     * @param string $name имя
     * @return object|null
     */
    public function searchByName($name)
    {
        if (empty($name)) {
            $name = 'root';
        }
        return $this->searchOneByField('name', $name);
    }

    public function searchByPath($path)
    {
        return $this->plugin('tree')->searchByPath($path . '/');
    }
}

?>