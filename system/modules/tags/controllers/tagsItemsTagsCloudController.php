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
 * tagsItemsTagsCloudController: контроллер для метода itemsTagsCloud модуля tags
 *
 * @package modules
 * @subpackage tags
 * @version 0.1
 */

class tagsItemsTagsCloudController extends simpleController
{
    public function getView()
    {
        $items = $this->request->get('items', 'array', SC_PATH);

        $tagsMapper = $this->toolkit->getMapper('tags', 'tags', 'tags');

        $tags = $tagsMapper->searchAllTagsByItems($items);

        $this->smarty->assign('tags', $tags);

        return $this->smarty->fetch('tags/itemsTagsCloud.tpl');
    }
}

?>