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

        try {
            $schema = $adminGeneratorMapper->getTableSchema($mapper->table());
        } catch (PDOException $e) {
            $controller = new messageController($e->getMessage(), messageController::WARNING);
            return $controller->run();
        }

        $map = $mapper->map();

        $add = array_diff_key($schema, $map);
        $delete = array_diff_key($map, $schema);

        $this->filterFakeFields($delete);
        $this->filterRelatedFields($delete, $mapper);
        $this->filterFakeFields($map);

        $add = $adminGeneratorMapper->mapFieldsFormatter($add);

        $map = array_merge($map, $add);
        foreach (array_keys($delete) as $key) {
            unset($map[$key]);
        }

        $dest = current($adminGeneratorMapper->getDests(true, $module['name']));

        if (sizeof($add) || sizeof($delete)) {
            try {
                $fileGenerator = new fileGenerator($dest . '/mappers');

                $map_str = $adminGeneratorMapper->generateMapString($map);

                $fileGenerator->edit($class['name'] . 'Mapper.php', new fileRegexpSearchReplaceTransformer('/(protected|public) \$map = array\s*\(.*?\);\r\n/s', '\\1 $map = ' . $map_str . ";\r\n"));

                $fileGenerator->run();
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }

        $this->smarty->assign('added', $add);
        $this->smarty->assign('deleted', array_keys($delete));

        return $this->smarty->fetch('admin/map.tpl');
    }

    private function filterFakeFields(&$array)
    {
        foreach ($array as $key => $val) {
            if (isset($val['options']) && (in_array('fake', $val['options']) || in_array('plugin', $val['options']))) {
                unset($array[$key]);
            }
        }
    }

    private function filterRelatedFields(&$array, $mapper)
    {
        $relations = $mapper->getRelations();

        foreach (array_keys($relations->manyToMany() + $relations->oneToOneBack() + $relations->oneToMany()) as $key) {
            unset($array[$key]);
        }
    }
}

?>