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
        $adminMapper = $this->toolkit->getMapper('admin', 'admin');
        $adminGeneratorMapper = $this->toolkit->getMapper('admin', 'adminGenerator');

        $module_name = $this->request->getString('module_name');
        try {
            $module = $this->toolkit->getModule($module_name);
        } catch (mzzModuleNotFoundException $e) {
            return $this->forward404($adminMapper);
        }

        $classes = $module->getClasses();
        $class_name = $this->request->getString('class_name');
        if (!in_array($class_name, $classes)) {
            return $this->forward404($adminMapper);
        }

        $mapper = $module->getMapper($class_name);

        try {
            $schema = $adminGeneratorMapper->getTableSchema($mapper->table());
        } catch (PDOException $e) {
            $controller = new messageController($this->getAction(), $e->getMessage(), messageController::WARNING);
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

        $dest = current($adminGeneratorMapper->getDests(true, $module->getName()));

        if (sizeof($add) || sizeof($delete)) {
            try {
                $fileGenerator = new fileGenerator($dest);
                $map_str = $adminGeneratorMapper->generateMapString($map);

                //echo '<pre>';
                //print_r($map_str);
                //exit;

                $fileGenerator->edit($adminGeneratorMapper->generateMapperFileName($class_name), new fileRegexpSearchReplaceTransformer('/(protected|public) \$map =\s+array\s*\(.*?\);[\r\n]+/s', '\\1 $map = ' . $map_str . ";\r\n"));

                $fileGenerator->run();
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }

        $this->view->assign('added', $add);
        $this->view->assign('deleted', array_keys($delete));

        return $this->view->render('admin/map.tpl');
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