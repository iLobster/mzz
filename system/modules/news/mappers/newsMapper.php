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
        $this->plugins('acl_ext');
        $this->plugins('jip');
        $this->plugins('i18n');
    }

    protected function preInsert(& $data)
    {
        if (is_array($data)) {
            $data['updated'] = $data['created'];
        }
    }

    protected function preUpdate(& $data)
    {
        if (is_array($data)) {
            $data['updated'] = new sqlFunction('UNIX_TIMESTAMP');
        }
    }

    /**
     * Выполняет поиск объектов по идентификатору каталога
     *
     * @param integer $id идентификатор папки
     * @return array
     */
    public function searchByFolder($folder_id)
    {
        return $this->searchAllByField('folder_id', $folder_id);
    }

    public function convertArgsToObj($args)
    {
        if (isset($args['id'])) {
            $news = $this->searchByKey($args['id']);
            if ($news) {
                return $news;
            }
        }

        throw new mzzDONotFoundException();
    }
}

?>