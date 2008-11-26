<?php
/**
 * $URL: http://svn.sandbox/repository/mzz/system/modules/tags/controllers/tagsEditTagsController.php $
 *
 * MZZ Content Management System (c) 2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: tagsEditTagsController.php 1121 2007-11-30 04:31:39Z zerkms $
 */

fileLoader::load('forms/validators/formValidator');

/**
 * tagsEditTagsController: контроллер для метода addTags модуля tags
 *
 * @package modules
 * @subpackage tags
 * @version 0.1
 */

class tagsEditTagsController extends simpleController
{
    public function getView()
    {
        $obj_id = $this->request->getInteger('id');
        $action = $this->request->getAction();

        $tagsItemMapper = $this->toolkit->getMapper('tags', 'tagsItem', 'tags');
        $tagsItem = $tagsItemMapper->searchOneByField('item_obj_id', $obj_id);

        if (!empty($tagsItem)) {
            $validator = new formValidator();

            if ($validator->validate()) {
                $tags = $this->request->getString('tags', SC_POST);
                $tagsItem->setTags($tags);
                $tagsItemMapper->save($tagsItem);
                return jipTools::refresh();
            }

            $url = new url('withId');
            $url->setAction($action);
            $url->add('id', $obj_id);

            $this->smarty->assign('tags', $tagsItem->getTagsAsString());
            $this->smarty->assign('action', $url->get());

            return $this->smarty->fetch('tags/editTags.tpl');
        }

        return $tagsItemMapper->get404()->run();
    }
}

?>