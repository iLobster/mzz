<?php
/**
 * $URL: http://svn.sandbox/repository/mzz/system/modules/news/controllers/newsSearchByTagController.php $
 *
 * MZZ Content Management System (c) 2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: newsSearchByTagController.php 1121 2007-11-30 04:31:39Z zerkms $
 */

/**
 * newsSearchByTagController: контроллер для метода searchByTag модуля news
 *
 * @package modules
 * @subpackage news
 * @version 0.1
 */

class newsSearchByTagController extends simpleController
{
    public function getView()
    {
        $tagsItemMapper = $this->toolkit->getMapper('tags', 'tagsItem', 'tags');
        $tagsMapper = $this->toolkit->getMapper('tags', 'tags', 'tags');
        $newsMapper = $this->toolkit->getMapper('news', 'news', 'news');

        $section = $this->request->getRequestedSection();
        $tag = urldecode($this->request->getString('tag'));

        $obj_ids =  $tagsMapper->searchObjIdsByTag($tag);
        $items = $newsMapper->searchByObjIds($criteria);

        $this->smarty->assign('news', $items);
        return $this->smarty->fetch('news/tagged.tpl');
    }
}

?>