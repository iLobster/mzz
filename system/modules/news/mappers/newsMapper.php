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

fileLoader::load('news/models/news');
fileLoader::load('modules/comments/plugins/commentsPlugin');
fileLoader::load('modules/jip/plugins/jipPlugin');
fileLoader::load('modules/i18n/plugins/i18nPlugin');

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
            'relation' => 'one',
            'foreign_key' => 'id',
            'mapper' => 'news/newsFolder'
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
            'mapper' => 'user/user'
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
            'orderBy' => 1,
            'orderByDirection' => 'DESC',
        ),
        'updated' => array(
            'accessor' => 'getUpdated',
            'mutator' => 'setUpdated',
        ),
    );

    public function __construct($module)
    {
        parent::__construct($module);
        $this->plugins('jip');
        $this->plugins('i18n');
        $this->plugins('comments');
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
}

?>