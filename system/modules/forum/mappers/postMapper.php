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

fileLoader::load('forum/post');

/**
 * postMapper: маппер
 *
 * @package modules
 * @subpackage forum
 * @version 0.1
 */

class postMapper extends simpleMapper
{
    /**
     * Имя модуля
     *
     * @var string
     */
    protected $name = 'forum';

    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $className = 'post';

    /**
     * Выполнение операций с массивом $fields перед вставкой в БД
     *
     * @param array $fields
     */
    protected function insertDataModify(&$fields)
    {
        $fields['post_date'] = new sqlFunction('UNIX_TIMESTAMP');

        $toolkit = systemToolkit::getInstance();

        $profileMapper = $toolkit->getMapper('forum', 'profile');
        $profile = $profileMapper->searchByUser($toolkit->getUser());

        $profile->setMessages($profile->getMessages() + 1);
        $profileMapper->save($profile);

        $threadMapper = $toolkit->getMapper('forum', 'thread');
        $thread = $threadMapper->searchByKey($fields['thread_id']);

        $thread->setPostsCount($thread->getPostsCount() + 1);
        $threadMapper->save($thread);

        $forum = $thread->getForum();
        if ($thread->getPostsCount() == 0) {
            $forum->setThreadsCount($forum->getThreadsCount() + 1);
        }
        $forum->setPostsCount($forum->getPostsCount() + 1);
        $forum->getMapper()->save($forum);
    }

    /**
     * Выполнение операций с массивом $fields перед обновлением в БД
     *
     * @param array $fields
     */
    protected function updateDataModify(&$fields)
    {
        $fields['edit_date'] = new sqlFunction('UNIX_TIMESTAMP');
    }

    /**
     * Возвращает доменный объект по аргументам
     *
     * @return simple
     */
    public function convertArgsToObj($args)
    {
        $do = $this->searchByKey($args['id']);

        if ($do) {
            return $do;
        }

        throw new mzzDONotFoundException();
    }
}

?>