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

    public function storeView($id)
    {
        $this->session->set('forum[' . $this->section() . '][' . $id . ']', time());
    }

    public function retrieveView($id)
    {
        return $this->session->get('forum[' . $this->section() . '][' . $id . ']');
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