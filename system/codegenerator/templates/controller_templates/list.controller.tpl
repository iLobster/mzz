<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/codegenerator/templates/controller.tpl $
 *
 * MZZ Content Management System (c) {{"Y"|date}}
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: controller.tpl 2200 2007-12-06 06:52:05Z zerkms $
 */

/**
 * {{$controller_data.controllername}}: контроллер для метода {{$controller_data.action}} модуля {{$controller_data.module}}
 *
 * @package modules
 * @subpackage {{$controller_data.module}}
 * @version 0.1
 */

class {{$controller_data.controllername}} extends simpleController
{
    protected function getView()
    {
        ${{$controller_data.class}}Mapper = $this->toolkit->getMapper('{{$controller_data.module}}', '{{$controller_data.class}}');
        $config = $this->toolkit->getConfig('{{$controller_data.module}}', $this->request->getSection());

        $this->setPager(${{$controller_data.class}}Mapper, $config->get('items_per_page'));

        $this->smarty->assign('items', ${{$controller_data.class}}Mapper->searchAll());
        $this->smarty->assign('obj_id', ${{$controller_data.class}}Mapper->convertArgsToObj(null)->getObjId());

        // Yeee eee eee
        return $this->smarty->fetch('{{$controller_data.module}}/{{$controller_data.action}}.tpl');
    }
}

?>