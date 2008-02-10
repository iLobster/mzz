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
 * @version 0.2
 */

class adminReadmapController extends simpleController
{
    protected function getView()
    {
        $class_name = $this->request->getString('name');

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
        $langTableError = null;
        foreach ($sections as $section) {
            $mapper = systemToolkit::getInstance()->getMapper($module['name'], $class['name'], $section['name']);
            $table = $mapper->getTable();
            $langTable = $mapper->getLangTable();
            $tableKey = $mapper->getTableKey();
            $tableLangField = $mapper->getLangIdField();

            $qry = 'SHOW COLUMNS FROM `' . $table . '`';
            $res = $db->getAll($qry);

            $tmp = array();
            $lang = array();
            foreach ($res as $field) {
                $tmp[] = $field['Field'];
            }

            $qry = 'SHOW COLUMNS FROM `' . $langTable . '`';
            try {
                $resLang = $db->getAll($qry);
                // собираем языкозависимые поля
                if (is_array($resLang)) {
                    foreach ($resLang as $field) {
                        // пропуская primary key и поле с идентификатором языка
                        if ($field['Field'] != $tableKey && $field['Field'] != $tableLangField) {
                            $lang[$field['Field']] = true;
                        }
                    }
                }
            } catch (PDOException $e) {
                // скорее всего таблицы с языками просто не существует,
                // но предупредим об ошибке, только если существуют языкозависимые поля в map
                $langTableError = $e->getMessage();
            }

            $schemas[] = array('fields' => $tmp, 'langFields' => $lang);
        }
        //@todo: реализовать ситуацию, когда таблицы не совпадают по полям

        if (isset($schemas[0])) {
            $scheme = $schemas[0]['fields'];
            $schemeLang = $schemas[0]['langFields'];
        } else {
            $scheme = array();
            $schemeLang = array();
        }

        $mapfile_name = $module['name'] . '/maps/' . $class['name'] . '.map.ini';
        $file = new iniFile(fileLoader::resolve($mapfile_name));
        $mapfile = $file->read();

        if (($key = array_search('obj_id', $scheme)) !== false) {
            unset($scheme[$key]);
        }

        $delete = array_diff(array_keys($mapfile), $scheme);

        // если поле языкозависомое, значит оно в таблице с переводами и не подлежит удалению
        //
        foreach ($delete as $key => $deletedField) {
            if (isset($schemeLang[$deletedField])) {
                unset($delete[$key]);
            }
        }

        $insert = array_diff($scheme, array_keys($mapfile));

        // собираем все поля из map-файла, помеченные как языкозависимые
        $langKeys = array();
        foreach ($mapfile as $key => $properties) {
            if (isset($properties['lang']) && $properties['lang']) {
                $langKeys[] = $key;
            }
        }

        if (empty($langKeys)) {
            $langTableError = null;
        }

        // и находим разницу между map и структурой таблицы с переводами
        $insertLang = array_diff(array_keys($schemeLang), $langKeys);

        $added = array();
        // убираем пометку с поля о языкозависимости если ее перенесли из таблицу переводов в основную
        foreach ($langKeys as $langKey) {
            if (!isset($schemeLang[$langKey]) && in_array($langKey, $delete) === false && !isset($insert[$langKey])) {
                $changed = true;
                unset($mapfile[$langKey]['lang']);
                $added[$langKey] = true;
            }
        }

        // добавляем поля из основной таблицу
        foreach ($insert as $field) {
            $changed = true;
            $name = ucfirst(preg_replace('/_([a-z])/ie', 'strtoupper("$1")', strtolower($field)));
            $mapfile[$field] = array('accessor' => 'get' . $name, 'mutator' => 'set' . $name);
            $added[$field] = true;
        }

        // добавлям или обновляем поля из таблицы переводов. Обновление заключается в пометке поля как lang, если
        // до этого оно уже было в map без нее
        foreach ($insertLang as $field) {
            $changed = true;
            if (isset($mapfile[$field])) {
                $mapfile[$field]['lang'] = true;
            } else {
                $name = ucfirst(preg_replace('/_([a-z])/ie', 'strtoupper("$1")', strtolower($field)));
                $mapfile[$field] = array('accessor' => 'get' . $name, 'mutator' => 'set' . $name, 'lang' => true);
            }
            $added[$field] = true;
        }

        if (isset($changed)) {
            $file->write($mapfile);
        }

        $this->smarty->assign('fields', $mapfile);
        $this->smarty->assign('delete', $delete);
        $this->smarty->assign('langFields', $schemeLang);
        $this->smarty->assign('added', $added);
        $this->smarty->assign('class', $class['name']);
        $this->smarty->assign('langTableError', $langTableError);
        return $this->smarty->fetch('admin/readmap.tpl');
    }
}

?>