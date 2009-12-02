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

        $action = $this->request->getAction();

        $isEdit = strpos($action, 'edit') !== false;

        if ($isEdit) {
            $id = $this->request->getInteger('id');
            ${{$name}} = ${{$name}}Mapper->searchByKey($id);
            if (empty(${{$name}})) {
                return $this->forward404(${{$name}}Mapper);
            }
        } else {
            ${{$name}} = ${{$name}}Mapper->create();
        }

        $validator = new formValidator();

{{foreach from=$map item=property key=field}}{{assign var="propertyType" value=$property.type|default:false}}
{{if !isset($property.options) || !in_array('pk', $property.options) || !in_array('once', $property.options)}}
        $validator->rule('required', '{{$name}}[{{$field}}]', 'Field {{$field}} is required');
{{if $propertyType === 'char' || $propertyType === 'varchar'}}
        $validator->rule('length', '{{$name}}[{{$field}}]', 'Field {{$field}} is out of length', array(0, {{$property.maxlength|default:255}}));
{{elseif $propertyType === 'int'}}
        $validator->rule('numeric', '{{$name}}[{{$field}}]', 'Field {{$field}} is not numeric as expected');
        {{assign var="propertyRange" value=$property.range|default:false}}{{if $propertyRange}}$validator->rule('range', '{{$name}}[{{$field}}]', 'Field {{$field}} is out of range', array({{$property.range[0]}}, {{$property.range[1]}}));
{{/if}}{{/if}}{{/if}}
{{/foreach}}

        if ($validator->validate()) {
            $data = $this->request->getArray('{{$name}}', SC_POST);

{{foreach from=$map item=property key=field}}
{{if !isset($property.options) || !in_array('pk', $property.options) || !in_array('once', $property.options)}}
${{$name}}->{{$property.mutator}}($data['{{$field}}']);
{{/if}}
            {{/foreach}}

            ${{$name}}Mapper->save(${{$name}});

            return jipTools::redirect();
        }

        if ($isEdit) {
            $url = new url('withId');
            $url->add('id', $id);
        } else {
            $url = new url('default2');
        }
        $url->setAction($action);

        $this->smarty->assign('form_action', $url->get());
        $this->smarty->assign('validator', $validator);
        $this->smarty->assign('{{$name}}', ${{$name}});
        $this->smarty->assign('isEdit', $isEdit);

        return $this->smarty->fetch('{{$module->getName()}}/{{$action_name}}.tpl');
    }
}

?>