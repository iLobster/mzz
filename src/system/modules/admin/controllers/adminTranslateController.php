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
        try {
            $module = $this->toolkit->getModule($this->request->getString('module_name'));
        } catch (mzzModuleNotFoundException $e) {
            return 'ERROR: module not found';
        }

        $locale = $this->toolkit->getLocale()->searchAll($this->request->getString('language'));

        if (!$locale) {
            return 'ERROR: language not found';
        }

        $storage_default = new i18nStorageIni($module->getName(), $locale->getName());
        $this->view->assign('plurals', range(0, $locale->getPluralsCount() - 1));
        $this->view->assign('translates', $storage_default->export());
        return $this->render('admin/translateFrm.tpl');
        return $module->getName() . '@' . $locale->getName();
        

        $modules = array();
        foreach ($adminMapper->getModules() as $module) {
            try {
                fileLoader::resolve($module->getName() . '/i18n/' . systemConfig::$i18n . '.ini');
                $modules[] = $module->getName();
            } catch (mzzIoException $e) {
            }
        }

        $langs = fLocale::searchAll();

        try {
            if (!is_null($module_name) && !is_null($language) && in_array($module_name, $modules)) {
                $storage = new i18nStorageIni($module_name, $language);
                $locale = new fLocale($language);

                if ($language != systemConfig::$i18n) {
                    $storage_default = new i18nStorageIni($module_name, systemConfig::$i18n);
                    $this->view->assign('not_default', true);
                    $this->view->assign('variables_default', $storage_default->export());

                    $locale_default = new fLocale(systemConfig::$i18n);
                    $this->view->assign('locale_default', $locale_default);
                } else {
                    $storage_default = $storage;
                }

                $validator = new formValidator();

                if ($validator->validate()) {
                    $apply = $this->request->getString('apply', SC_POST);

                    $variables = $this->request->getArray('variable', SC_POST);
                    $comments = $this->request->getArray('comment', SC_POST);

                    $comments = array_filter($comments, array($this, 'notEmpty'));

                    foreach ($variables as $name => $variable) {
                        $variable = array_filter($variable, array($this, 'notEmpty'));
                        $storage->write($name, $variable);
                    }

                    foreach ($comments as $name => $comment) {
                        $storage_default->setComment($name, $comment);
                    }

                    $storage_default->save();
                    $storage->save();

                    if (!is_null($apply)) {
                        $url = new url();
                        $url->add('module_name', $module_name);
                        $url->add('language', $language);
                    } else {
                        $url = new url('default2');
                        $url->setAction($this->request->getAction());
                    }

                    return $this->response->redirect($url->get());
                }

                $url = new url();
                $url->add('module_name', $module_name);
                $url->add('language', $language);

                $this->view->assign('storage_default', $storage_default);
                $this->view->assign('form_action', $url->get());
                $this->view->assign('locale', $locale);
                $this->view->assign('plurals', range(0, $locale->getPluralsCount() - 1));
                $this->view->assign('variables', $storage->export());

                return $this->render('admin/translateForm.tpl');
            }
        } catch (mzzIoException $e) {
        }

        $this->view->assign('langs', $langs);
        $this->view->assign('modules', $modules);

        return $this->render('admin/translateList.tpl');
    }

    public function notEmpty($value)
    {
        return $value != '';
    }
}

?>