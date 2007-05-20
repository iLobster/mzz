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

fileLoader::load('codegenerator/actionGenerator');

/**
 * adminDeleteActionController: контроллер для метода deleteAction модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1.1
 */
class adminDeleteActionController extends simpleController
{
    public function getView()
    {
        $id = $this->request->get('id', 'integer', SC_PATH);
        $action_name = $this->request->get('action_name', 'string', SC_PATH);

        $db = DB::factory();
        $data = $db->getRow('SELECT `c`.`id` AS `c_id`, `m`.`id` AS `m_id`, `c`.`name` AS `c_name`, `m`.`name` AS `m_name` FROM `sys_classes` `c` INNER JOIN `sys_modules` `m` ON `m`.`id` = `c`.`module_id` WHERE `c`.`id` = ' . $id);

        if (!$data) {
            return 'класс не найден';
        }

        $const = DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR;
        $dest = (file_exists(systemConfig::$pathToApplication . $const . $data['m_name'] . DIRECTORY_SEPARATOR . 'actions')) ? systemConfig::$pathToApplication : systemConfig::$pathToSystem;
        $dest .= DIRECTORY_SEPARATOR . 'modules';

        $actionGenerator = new actionGenerator($data['m_name'], $dest, $data['c_name']);
        try {
            $actionGenerator->delete($action_name);
        } catch (Exception $e) {
            return $e;
        }

        $url = new url('default2');
        $url->setAction('devToolbar');
        return jipTools::redirect($url->get());
    }
}

?>