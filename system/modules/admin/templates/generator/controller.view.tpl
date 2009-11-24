{{*<?*}}{{chr(60)}}?php
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
 * {{$module->getName()}}{{$actionData.controller|ucfirst}}Controller
 *
 * @package modules
 * @subpackage {{$module->getName()}}
 * @version 0.0.1
 */
class {{$module->getName()}}{{$actionData.controller|ucfirst}}Controller extends simpleController
{
    protected function getView()
    {
        ${{$name}}Mapper = $this->toolkit->getMapper('{{$module->getName()}}', '{{$name}}');

        $id = $this->request->getInteger('id');
        ${{$name}} = ${{$name}}Mapper->searchByKey($id);

        if (empty(${{$name}})) {
            return $this->forward404(${{$name}}Mapper);
        }

        $this->smarty->assign('{{$name}}', ${{$name}});

        return $this->smarty->fetch('{{$module->getName()}}/{{$action_name}}.tpl');
    }
}

?>