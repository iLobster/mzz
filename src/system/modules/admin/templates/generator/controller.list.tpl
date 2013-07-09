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

        $this->setPager(${{$name}}Mapper);

        $all = ${{$name}}Mapper->searchAll();

        $this->view->assign('all', $all);
        return $this->render('{{$module->getName()}}/{{$action_name}}.tpl');
    }
}

?>