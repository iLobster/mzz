<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/system/codegenerator/templates/controller.tpl $
 *
 * MZZ Content Management System (c) 2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: controller.tpl 1790 2007-06-07 09:48:45Z mz $
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
        $section = $this->request->getRequestedSection();
        $class = $this->request->get('tclass', 'string', SC_PATH);
        $module = $this->request->get('tmodule', 'string', SC_PATH);

        $itemsMapper = $this->toolkit->getMapper($module, $class, $section);

        $criteria = new criteria($itemsMapper->getTable(), 't');
        $criteria->addSelectField('obj_id');
        $db = DB::factory();
        $s = new simpleSelect($criteria);
        $obj_ids = $db->getAll($s->toString(), PDO::FETCH_COLUMN);

        $tagsMapper = $this->toolkit->getMapper('tags', 'tags', 'tags');
        $tags = $tagsMapper->searchAllTagsByItems($obj_ids);

        $this->smarty->assign('tags', $tags);

        return $this->smarty->fetch('tags/tagsCloud.tpl');
    }
}

?>