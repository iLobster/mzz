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

/**
 * configEditCfgController: контроллер для метода editCfg модуля config
 *
 * @package modules
 * @subpackage config
 * @version 0.1
 */

fileLoader::load('config/views/configEditCfgView');

class configEditCfgController extends simpleController
{
    public function getView()
    {
        $module_name = $this->request->get('module_name', 'string', SC_PATH);
        $section_name = $this->request->get('section_name', 'string', SC_PATH);

        if ($this->request->getMethod() == 'POST') {
            $cfg = $this->request->get('config', 'array', SC_POST);
            $config = $this->toolkit->getConfig($section_name, $module_name);
            $config->set($cfg);

            $url = new url();
            return new simpleJipCloseView();
        }

        return new configEditCfgView($module_name, $section_name);
    }
}

?>