<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2009
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

fileLoader::load('codegenerator/fileGenerator');
fileLoader::load('codegenerator/fileRegexpSearchReplaceTransformer');

/**
 * adminMapController
 *
 * @package modules
 * @subpackage admin
 * @version 0.1
 */
class adminMapController extends simpleController
{
    protected function getView()
    {
        $id = $this->request->getInteger('id');

        $adminMapper = $this->toolkit->getMapper('admin', 'admin');
        $adminGeneratorMapper = $this->toolkit->getMapper('admin', 'adminGenerator');

        $class = $adminMapper->searchClassById($id);

        if (!$class) {
            $controller = new messageController(i18n::getMessage('class.error.not_exists', 'admin'), messageController::WARNING);
            return $controller->run();
        }

        $module = $adminMapper->searchModuleById($class['module_id']);

        $mapper = $this->toolkit->getMapper($module['name'], $class['name']);

        $schema = $adminGeneratorMapper->getTableSchema($mapper->table());

        $map = $mapper->map();

        $add = array_diff_key($schema, $map);
        $delete = array_diff_key($map, $schema);

        foreach ($add as $key => & $value) {
            $key = explode('_', $key);
            $key = array_map('ucfirst', $key);
            $key = implode('', $key);

            $value['accessor'] = 'get' . $key;
            $value['mutator'] = 'set' . $key;

            if (isset($value['options']) && in_array('pk', $value['options'])) {
                $value['options'][] = 'once';
            }
        }

        $map = array_merge($map, $add);
        foreach (array_keys($delete) as $key) {
            unset($map[$key]);
        }

        $dest = current($adminGeneratorMapper->getDests(true, $module['name']));

        if (sizeof($add) || sizeof($delete)) {
            try {
                $fileGenerator = new fileGenerator($dest . '/mappers');

                $map_str = var_export($map, true);
                $map_str = preg_replace('/^( +)/m', '$1$1', $map_str);
                $map_str = preg_replace('/^/m', str_repeat(' ', 4) . '\\1', $map_str);
                $map_str = trim($map_str);

                $fileGenerator->edit($class['name'] . 'Mapper.php', new fileRegexpSearchReplaceTransformer('/protected \$map = array\s*\(.*?\);\r\n/s', 'protected $map = ' . $map_str . ";\r\n"));

                $fileGenerator->run();
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }

        $this->smarty->assign('added', $add);
        $this->smarty->assign('deleted', array_keys($delete));

        return $this->smarty->fetch('admin/map.tpl');
    }
}

?>