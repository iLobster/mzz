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
 * adminTranslateController: контроллер для метода translate модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1
 */

class adminTranslateController extends simpleController
{
    protected function getView()
    {
        $module_name = $this->request->getString('module_name');
        $language = $this->request->getString('language');

        $adminMapper = $this->toolkit->getMapper('admin', 'admin');

        $modules = array();
        foreach ($adminMapper->getModulesList() as $module) {
            try {
                fileLoader::resolve($module['name'] . '/i18n/' . systemConfig::$i18n . '.ini');
                $modules[] = $module['name'];
            } catch (mzzIoException $e) {
            }

        }

        $langs = locale::searchAll();

        try {
            if (!is_null($module_name) && !is_null($language) && in_array($module_name, $modules)) {
                $storage = new i18nStorageIni($module_name, $language);
                $locale = new locale($language);

                $this->smarty->assign('locale', $locale);
                $this->smarty->assign('plurals', range(0, $locale->getPluralsCount() - 1));
                $this->smarty->assign('variables', $storage->export());

                return $this->smarty->fetch('admin/translateForm.tpl');
            }
        } catch (mzzIoException $e) {
        }

        $this->smarty->assign('langs', $langs);
        $this->smarty->assign('modules', $modules);

        return $this->smarty->fetch('admin/translateList.tpl');
    }
}

?>