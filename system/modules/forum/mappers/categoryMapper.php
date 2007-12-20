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

fileLoader::load('forum/category');

/**
 * categoryMapper: маппер
 *
 * @package modules
 * @subpackage forum
 * @version 0.1
 */

class categoryMapper extends simpleMapper
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
    protected $className = 'category';

    public function delete(category $category)
    {
        $forumMapper = systemToolkit::getInstance()->getMapper('forum', 'forum', $this->section);

        foreach ($category->getForums() as $forum) {
            $forumMapper->delete($forum);
        }

        parent::delete($category);
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