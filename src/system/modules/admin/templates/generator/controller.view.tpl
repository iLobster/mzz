{{*<?*}}{{chr(60)}}?php
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

        $this->view->assign('{{$name}}', ${{$name}});

        return $this->render('{{$module->getName()}}/{{$action_name}}.tpl');
    }
}

?>