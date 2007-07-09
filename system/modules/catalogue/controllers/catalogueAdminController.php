<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * catalogueAdminController: контроллер для метода edit модуля catalogue
 *
 * @package modules
 * @subpackage catalogue
 * @version 0.1
 */

class catalogueAdminController extends simpleController
{
    protected function getView()
    {
        $catalogueMapper = $this->toolkit->getMapper('catalogue', 'catalogue');
        $catalogueFolderMapper = $this->toolkit->getMapper('catalogue', 'catalogueFolder');

        $path = $this->request->get('params', 'string', SC_PATH);

        if (is_null($path)) {
            $path = 'root';
        }

        $catalogueFolder = $catalogueFolderMapper->searchByPath($path);

        $chain = $catalogueFolderMapper->getPath($catalogueFolder->getId());
        $this->smarty->assign('chains', $chain);

        $types = $catalogueMapper->getAllTypes();
        $properties = $catalogueMapper->getAllProperties();

        $jipTypes = array();
        $url = new url('withId');
        foreach($types as $type){
            $url->addParam('id', $type['id']);

            $url->setAction('editType');
            $jipTypes[$type['id']][] = array(
                            "title" => 'Редактировать',
                            "url" => $url->get(),
                            "icon" => SITE_PATH . '/templates/images/edit.gif'
                        );

            $url->setAction('deleteType');
            $jipTypes[$type['id']][] = array(
                            "title" => 'Удалить',
                            "url" => $url->get(),
                            "icon" => SITE_PATH . '/templates/images/delete.gif'
                        );
        }

        $jipProperties = array();
        $url = new url('withId');
        foreach($properties as $property){
            $url->addParam('id', $property['id']);
            $url->setAction('editProperty');
            $jipProperties[$property['id']][] = array(
                            "title" => 'Редактировать',
                            "url" => $url->get(),
                            "icon" => SITE_PATH . '/templates/images/edit.gif'
                        );

            $url->setAction('deleteProperty');
            $jipProperties[$property['id']][] = array(
                            "title" => 'Удалить',
                            "url" => $url->get(),
                            "icon" => SITE_PATH . '/templates/images/delete.gif'
                        );
        }

        $pager = $this->setPager($catalogueFolder);

        $this->smarty->assign('jipTypes', $jipTypes);
        $this->smarty->assign('jipProperties', $jipProperties);
        $this->smarty->assign('types', $types);
        $this->smarty->assign('properties', $properties);
        $this->smarty->assign('items', $catalogueFolder->getItems());
        $this->smarty->assign('catalogueFolder', $catalogueFolder);
        return $this->smarty->fetch('catalogue/admin.tpl');
    }
}

?>