<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

fileLoader::load('page/models/page');
fileLoader::load('modules/jip/plugins/jipPlugin');
fileLoader::load('modules/i18n/plugins/i18nPlugin');

/**
 * pageMapper: маппер для страниц
 *
 * @package modules
 * @subpackage page
 * @version 0.2.1
 */
class pageMapper extends mapper
{
    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $class = 'page';
    protected $table = 'page_page';

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
        'content' => array(
            'accessor' => 'getContent',
            'mutator' => 'setContent',
            'options' => array(
                'i18n')),
        'keywords' => array(
            'accessor' => 'getKeywords',
            'mutator' => 'setKeywords',
            'options' => array(
                'i18n')),
        'description' => array(
            'accessor' => 'getDescription',
            'mutator' => 'setDescription',
            'options' => array(
                'i18n')),
        'title' => array(
            'accessor' => 'getTitle',
            'mutator' => 'setTitle',
            'options' => array(
                'i18n')),
        'compiled' => array(
            'accessor' => 'getCompiled',
            'mutator' => 'setCompiled'),
        'allow_comment' => array(
            'accessor' => 'getAllowComment',
            'mutator' => 'setAllowComment'),
        'folder_id' => array(
            'accessor' => 'getFolder',
            'mutator' => 'setFolder',
            'relation' => 'one',
            'foreign_key' => 'id',
            'mapper' => 'page/pageFolder'),
        'keywords_reset' => array(
            'accessor' => 'isKeywordsReset',
            'mutator' => 'setKeywordsReset'),
        'description_reset' => array(
            'accessor' => 'isDescriptionReset',
            'mutator' => 'setDescriptionReset'));

    public function __construct($module)
    {
        parent::__construct($module);
        $this->plugins('i18n');
        $this->plugins('jip');
    }

    /**
     * Выполняет поиск объекта по идентификатору
     *
     * @param integer $id идентификатор
     * @return object|null
     */
    public function searchById($id)
    {
        return $this->searchOneByField('id', $id);
    }

    /**
     * Выполняет поиск объектов по идентификатору папки
     *
     * @param integer $id идентификатор папки
     * @return array
     */
    public function searchByFolder($folder_id)
    {
        return $this->searchAllByField('folder_id', $folder_id);
    }

    /**
     * Выполняет поиск объекта по имени
     *
     * @param string $name имя
     * @return object|null
     */
    public function searchByName($name)
    {
        return $this->searchOneByField('name', $name);
    }

    public function searchByNameInFolder($name, $folder_id)
    {
        $criteria = new criteria();
        $criteria->where('name', $name)->where('folder_id', $folder_id);
        return $this->searchOneByCriteria($criteria);
    }
}

?>