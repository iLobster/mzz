<?php
/**
 * $URL: http://svn.sandbox/repository/mzz/system/modules/tags/controllers/tagsTagsCloudController.php $
 *
 * MZZ Content Management System (c) 2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: tagsTagsCloudController.php 1121 2007-11-30 04:31:39Z zerkms $
 */

/**
 * tagsTagsCloudController: контроллер для метода tagsCloud модуля tags
 *
 * @package modules
 * @subpackage tags
 * @version 0.1
 */

class tagsTagsCloudController extends simpleController
{
    public function getView()
    {
        $section = $this->request->getString('tagSection');
        if (empty($section)) {
            $section = $this->request->getRequestedSection();
        }
        $class = $this->request->getString('tclass');
        $module = $this->request->getString('tmodule');
        $action = $this->request->getString('tagAction');

        $itemsMapper = $this->toolkit->getMapper($module, $class, $section);
        if ($itemsMapper instanceof iTaggable) {
            $obj_ids = $itemsMapper->getTaggedObjIds();
        } else {
            $criteria = new criteria($itemsMapper->getTable(), 't');
            $criteria->addSelectField('obj_id');
            $db = DB::factory();
            $s = new simpleSelect($criteria);
            $obj_ids = $db->getAll($s->toString(), PDO::FETCH_COLUMN);
        }

        $tagsMapper = $this->toolkit->getMapper('tags', 'tags', 'tags');
        $tags = $tagsMapper->searchAllTagsByItems($obj_ids);

        $this->smarty->assign('tags', $tags);
        $this->smarty->assign('module', $module);
        $this->smarty->assign('class', $class);
        $this->smarty->assign('section', $section);
        $this->smarty->assign('action', $action);

        return $this->smarty->fetch('tags/tagsCloud.tpl');
    }
}

?>