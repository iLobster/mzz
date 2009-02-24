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

fileLoader::load('page');
fileLoader::load('orm/plugins/acl_extPlugin');

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
                'once',
            ),
        ),
        'compiled' => array(
            'accessor' => 'getCompiled',
            'mutator' => 'setCompiled',
        ),
        'allow_comment' => array(
            'accessor' => 'getAllowComment',
            'mutator' => 'setAllowComment',
        ),
        'folder_id' => array(
            'accessor' => 'getFolder',
            'mutator' => 'setFolder',
        ),
    );

    public function __construct()
    {
        parent::__construct();
        $this->attach(new acl_extPlugin(), 'acl');
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

    public function convertArgsToObj($args)
    {
        if (isset($args['id']) && !isset($args['name'])) {
            $args['name'] = $args['id'];
        }

        if (strpos($args['name'], '/') !== false) {
            $toolkit = systemToolkit::getInstance();
            $pageFolderMapper = $toolkit->getMapper('page', 'pageFolder');

            $folder = substr($args['name'], 0, strrpos($args['name'], '/'));
            $pagename = substr(strrchr($args['name'], '/'), 1);

            $pageFolder = $pageFolderMapper->searchByPath($folder);

            if (empty($pageFolder)) {
                throw new mzzDONotFoundException();
            }

            $criteria = new criteria();
            $criteria->add('name', $pagename)->add('folder_id', $pageFolder->getId());
            $page = $this->searchOneByCriteria($criteria);
        }

        if (!isset($page)) {
            $page = $this->searchOneByField('name', $args['name']);
        }

        if ($page) {
            return $page;
        }

        throw new mzzDONotFoundException();
    }
}

?>