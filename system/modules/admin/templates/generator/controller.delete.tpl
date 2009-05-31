<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) {{"Y"|date}}
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * {{$controller_data.module}}{{$controller_data.name|ucfirst}}Controller
 *
 * @package modules
 * @subpackage {{$controller_data.module}}
 * @version 0.1
 */

class {{$controller_data.module}}{{$controller_data.name|ucfirst}}Controller extends simpleController
{
    protected function getView()
    {
        ${{$controller_data.class}}Mapper = $this->toolkit->getMapper('{{$controller_data.module}}', '{{$controller_data.class}}');

        $id = $this->request->getInteger('id');
        ${{$controller_data.class}}Mapper->delete($id);

        return jipTools::redirect();
    }
}

?>