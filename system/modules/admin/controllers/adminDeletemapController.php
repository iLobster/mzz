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
 * adminDeletemapController: контроллер для удаления поля
 *
 * @package modules
 * @subpackage admin
 * @version 0.1
 */

class adminDeletemapController extends simpleController
{
    protected function getView()
    {
        $class_name = $this->request->get('class', 'string');
        $field_name = $this->request->get('field', 'string');

        $adminMapper = $this->toolkit->getMapper('admin', 'admin');
        $class = $adminMapper->searchClassByName($class_name);

        if (!$class) {
            $controller = new messageController('Класса не существует', messageController::WARNING);
            return $controller->run();
        }

        $module = $adminMapper->searchModuleByClassId($class['id']);

        $mapfile_name = $module['name'] . '/maps/' . $class['name'] . '.map.ini';
        $file = new iniFile(fileLoader::resolve($mapfile_name));
        $mapfile = $file->read();

        if (!isset($mapfile[$field_name])) {
            $controller = new messageController('У выбранного класса не существует поля ' . $field_name, messageController::WARNING);
            return $controller->run();
        }

        $db = DB::factory();

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

        $scheme = $schemas[0];

        //@todo: реализовать ситуацию, когда таблицы не совпадают по полям

        $delete = array_diff(array_keys($mapfile), $scheme);

        if (!in_array($field_name, $delete)) {
            $controller = new messageController('Невозможно удалить поле ' . $field_name, messageController::WARNING);
            return $controller->run();
        }

        unset($mapfile[$field_name]);

        $file->write($mapfile);

        return jipTools::closeWindow();
    }
}

?>