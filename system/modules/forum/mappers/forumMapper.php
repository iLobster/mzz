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

fileLoader::load('forum');

/**
 * forumMapper: маппер
 *
 * @package modules
 * @subpackage forum
 * @version 0.1
 */

class forumMapper extends simpleMapper
{
    /**
     * Имя модуля
     *
     * @var string
     */
    protected $name = 'forum';

    private $session;

    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $className = 'forum';

    public function __construct($section)
    {
        parent::__construct($section);
        $this->session = systemToolkit::getInstance()->getSession();
    }

    public function storeView($thread)
    {
        $this->session->set('forum[' . $this->section() . '][' . $thread->getId() . ']', time());

        if ($this->getLastThreadId() != $thread->getId()) {
            $this->setLastThreadId($thread->getId());

            $thread->setViewCount($thread->getViewCount() + 1);
            $thread->getMapper()->save($thread);
        }
    }

    public function retrieveView($id)
    {
        return $this->session->get('forum[' . $this->section() . '][' . $id . ']');
    }

    public function retrieveAllViews()
    {
        if (is_array($array = $this->session->get('forum[' . $this->section() . ']'))) {
            return array_keys($array);
        }

        return array();
    }

    public function setLastThreadId($id)
    {
        $this->session->set('forum[' . $this->section() . '_last_thread]', $id);
    }

    public function getLastThreadId()
    {
        return $this->session->get('forum[' . $this->section() . '_last_thread]');
    }

    public function getNewThreads()
    {
        $user = systemToolkit::getInstance()->getUser();

        if (!$user->isLoggedIn()) {
            return array();
        }

        $qry = 'SELECT `t`.`id` FROM `forum_thread` `t`
                 INNER JOIN `forum_post` `p` ON `p`.`id` = `t`.`last_post`
                  WHERE (`p`.`post_date` > ' . $user->getLastLogin() . (sizeof($this->retrieveAllViews()) ? ' AND `t`.`id` NOT IN (' . implode(', ', $this->retrieveAllViews()) . ')' : '') . ')';

        foreach ($this->retrieveAllViews() as $thread) {
            $qry .= ' OR (`t`.`id` = ' . $thread . ' AND `p`.`post_date` > ' . $this->retrieveView($thread) . ')';
        }

        $qry .= ' ORDER BY `p`.`post_date` DESC';

        $new = $this->db->getAll($qry);

        $result = array();
        foreach ($new as $thread) {
            $result[$thread['id']] = 1;
        }

        return $result;
    }

    public function getNewForums()
    {
        $user = systemToolkit::getInstance()->getUser();

        if (!$user->isLoggedIn()) {
            return array();
        }

        $qry = 'SELECT `t`.`forum_id` FROM `forum_thread` `t`
                 INNER JOIN `forum_post` `p` ON `p`.`id` = `t`.`last_post`
                  WHERE (`p`.`post_date` > ' . $user->getLastLogin() . (sizeof($this->retrieveAllViews()) ? ' AND `t`.`id` NOT IN (' . implode(', ', $this->retrieveAllViews()) . ')' : '') . ')';

        foreach ($this->retrieveAllViews() as $thread) {
            $qry .= ' OR (`t`.`id` = ' . $thread . ' AND `p`.`post_date` > ' . $this->retrieveView($thread) . ')';
        }

        $qry .= ' GROUP BY `t`.`forum_id`';

        $new = $this->db->getAll($qry);

        $result = array();
        foreach ($new as $thread) {
            $result[$thread['forum_id']] = 1;
        }

        return $result;
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