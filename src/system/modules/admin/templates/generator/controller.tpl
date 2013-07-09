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
        return $this->render('{{$module->getName()}}/{{$action_name}}.tpl');
    }
}
?>