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

fileLoader::load('service/iniFile');

/**
 * adminReadmapController: контроллер для просмотра содержимого map-файлов
 *
 * @package modules
 * @subpackage admin
 * @version 0.1
 */

class adminReadmapController extends simpleController
{
    protected function getView()
    {
        $class_name = $this->request->get('name', 'string');

        $adminMapper = $this->toolkit->getMapper('admin', 'admin');
        $class = $adminMapper->searchClassByName($class_name);

        if (!$class) {
            $controller = new messageController('Класса не существует', messageController::WARNING);
            return $controller->run();
        }

        $db = DB::factory();

        $module = $adminMapper->searchModuleByClassId($class['id']);
        $sections = $adminMapper->getSectionsModuleRegistered($module['id']);

        $schemas = array();
        foreach ($sections as $section) {
            $mapper = systemToolkit::getInstance()->getMapper($module['name'], $class['name'], $section['name']);
            $table = $mapper->getTable();

            $qry = 'SHOW COLUMNS FROM `' . $table . '`';
            $res = $db->getAll($qry);

            $tmp = array();
            foreach ($res as $field) {
                $tmp[] = $field['Field'];
            }

            $schemas[] = $tmp;
        }
        //@todo: реализовать ситуацию, когда таблицы не совпадают по полям

        if (isset($schemas[0])) {
            $scheme = $schemas[0];
        } else {
            $scheme = array();
        }

        $mapfile_name = $module['name'] . '/maps/' . $class['name'] . '.map.ini';
        $file = new iniFile(fileLoader::resolve($mapfile_name));
        $mapfile = $file->read();

        $key = array_search('obj_id', $scheme);
        unset($scheme[$key]);

        $delete = array_diff(array_keys($mapfile), $scheme);
        $insert = array_diff($scheme, array_keys($mapfile));

        foreach ($insert as $field) {
            $changed = true;
            $mapfile[$field] = array('accessor' => 'get' . ucfirst(strtolower($field)), 'mutator' => 'set' . ucfirst(strtolower($field)));
        }

        if (isset($changed)) {
            $file->write($mapfile);
        }

        $this->smarty->assign('fields', $mapfile);
        $this->smarty->assign('delete', $delete);
        $this->smarty->assign('class', $class['name']);
        return $this->smarty->fetch('admin/readmap.tpl');
    }
}

?>