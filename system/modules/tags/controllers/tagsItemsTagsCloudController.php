<?php
/**
 * $URL: http://svn.sandbox/repository/mzz/system/modules/tags/controllers/tagsItemsTagsCloudController.php $
 *
 * MZZ Content Management System (c) 2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: tagsItemsTagsCloudController.php 1121 2007-11-30 04:31:39Z zerkms $
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