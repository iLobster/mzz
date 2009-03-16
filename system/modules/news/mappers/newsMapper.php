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

fileLoader::load('news');
fileLoader::load('orm/plugins/acl_extPlugin');
fileLoader::load('orm/plugins/jipPlugin');
fileLoader::load('orm/plugins/i18nPlugin');

/**
 * newsMapper: маппер для новостей
 *
 * @package modules
 * @subpackage news
 * @version 0.3
 */
class newsMapper extends mapper
{
    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $class = 'news';
    protected $table = 'news_news';

    protected $map = array(
        'id' => array(
            'accessor' => 'getId',
            'mutator' => 'setId',
            'options' => array(
                'pk', 'once',
            ),
        ),
        'folder_id' => array(
            'accessor' => 'getFolder',
            'mutator' => 'setFolder',
        ),
        'title' => array(
            'accessor' => 'getTitle',
            'mutator' => 'setTitle',
            'options' => array(
                'i18n',
            ),
        ),
        'editor' => array(
            'accessor' => 'getEditor',
            'mutator' => 'setEditor',
            'relation' => 'one',
            'foreign_key' => 'id',
            'mapper' => 'userMapper'
        ),
        'annotation' => array(
            'accessor' => 'getAnnotation',
            'mutator' => 'setAnnotation',
            'options' => array(
                'i18n',
            ),
        ),
        'text' => array(
            'accessor' => 'getText',
            'mutator' => 'setText',
            'options' => array(
                'i18n',
            ),
        ),
        'created' => array(
            'accessor' => 'getCreated',
            'mutator' => 'setCreated',
            'options' => array(
                'once',
            ),
        ),
        'updated' => array(
            'accessor' => 'getUpdated',
            'mutator' => 'setUpdated',
        ),
    );

    public function __construct()
    {
        parent::__construct();
        $this->attach(new acl_extPlugin(), 'acl');
        $this->attach(new jipPlugin(), 'jip');
        $this->attach(new i18nPlugin(), 'i18n');
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
     * Выполнение операций с массивом $fields перед обновлением в БД
     *
     * @param array $fields
     */
    protected function updateDataModify(&$fields)
    {
        $fields['updated'] = new sqlFunction('UNIX_TIMESTAMP');
    }

    /**
     * Выполнение операций с массивом $fields перед вставкой в БД
     *
     * @param array $fields
     */
    protected function insertDataModify(&$fields)
    {
        $fields['updated'] = $fields['created'];
    }

    private function getObjId()
    {
        $obj_id = systemToolkit::getInstance()->getObjectId($this->section . '_searchByTag');
        $this->register($obj_id);
        return $obj_id;
    }

    public function convertArgsToObj($args)
    {
        if(isset($args['id'])) {
            $news = $this->searchByKey($args['id']);
            if ($news) {
                return $news;
            }
        }

        $action = systemToolkit::getInstance()->getRequest()->getRequestedAction();

        if($action == 'searchByTag') {
            $obj = $this->create();
            $obj->import(array('obj_id' => $this->getObjId()));
            return $obj;
        }

        throw new mzzDONotFoundException();
    }

    public function searchByObjIds($obj_ids)
    {
        $criteria = new criteria();
        $criterion = new criterion('obj_id', $obj_ids, criteria::IN);
        $criteria->add($criterion);

        return $this->searchAllByCriteria($criteria);
    }
}

?>