<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2008
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * catalogueAdminCatalogueController: контроллер для метода adminCatalogue модуля catalogue
 *
 * @package modules
 * @subpackage catalogue
 * @version 0.1
 */

class catalogueAdminCatalogueController extends simpleController
{
    protected function getView()
    {
        $catalogueMapper = $this->toolkit->getMapper('catalogue', 'catalogue');

        $adminMapper = $this->toolkit->getMapper('admin', 'admin');
        $this->smarty->assign('admin_menu', $adminMapper->getMenu());

        $this->smarty->assign('current_section', $this->request->getSection());
        $this->smarty->assign('current_module', 'user');

        $langs = locale::searchAll();
        $this->smarty->assign('langs', $langs);

        $action = $this->request->getAction();

        if ($action == 'adminProperties') {
            $properties = $catalogueMapper->getAllProperties();

            $jipProperties = array();
            $url = new url('withId');
            foreach($properties as $property){
                $url->add('id', $property['id']);
                $url->setAction('editProperty');
                $jipProperties[$property['id']][] = array(
                                'title' => 'Редактировать',
                                'url' => $url->get(),
                                'icon' => SITE_PATH . '/templates/images/edit.gif',
                                'lang' => false,
                            );

                $url->setAction('deleteProperty');
                $jipProperties[$property['id']][] = array(
                                'title' => 'Удалить',
                                'url' => $url->get(),
                                'icon' => SITE_PATH . '/templates/images/delete.gif',
                                'lang' => false,
                            );
            }

            $this->smarty->assign('properties', $properties);
            $this->smarty->assign('jipProperties', $jipProperties);
            return $this->smarty->fetch('catalogue/adminProperties.tpl');
        } else {
            $types = $catalogueMapper->getAllTypes();

            $jipTypes = array();
            $url = new url('withId');
            foreach($types as $type){
                $url->add('id', $type['id']);

                $url->setAction('editType');
                $jipTypes[$type['id']][] = array(
                                'title' => 'Редактировать',
                                'url' => $url->get(),
                                'icon' => SITE_PATH . '/templates/images/edit.gif',
                                'lang' => false,
                            );

                $url->setAction('deleteType');
                $jipTypes[$type['id']][] = array(
                                'title' => 'Удалить',
                                'url' => $url->get(),
                                'icon' => SITE_PATH . '/templates/images/delete.gif',
                                'lang' => false,
                            );
            }

            $this->smarty->assign('types', $types);
            $this->smarty->assign('jipTypes', $jipTypes);
            return $this->smarty->fetch('catalogue/adminTypes.tpl');
        }
    }
}

?>