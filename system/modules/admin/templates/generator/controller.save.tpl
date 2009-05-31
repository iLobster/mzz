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
        $action = $this->request->getAction();

        $isEdit = strpos($action, 'edit') !== false;

        if ($isEdit) {
            ${{$controller_data.class}} = ${{$controller_data.class}}Mapper->searchByKey($id);
            if (empty(${{$controller_data.class}})) {
                return $this->forward404(${{$controller_data.class}}Mapper);
            }
        } else {
            ${{$controller_data.class}} = ${{$controller_data.class}}Mapper->create();
        }

        $validator = new formValidator();

{{foreach from=$map item=property key=field}}
{{if !isset($property.options) || !in_array('pk', $property.options) || !in_array('once', $property.options)}}
$validator->add('required', '{{$controller_data.class}}[{{$field}}]', 'Field {{$field}} is required');
{{if $property.type eq 'char'}}
        $validator->add('length', '{{$controller_data.class}}[{{$field}}]', 'Field {{$field}} is out of length', array(0, {{$property.maxlength}}));
{{else if $property.type eq 'int'}}
        $validator->add('numeric', '{{$controller_data.class}}[{{$field}}]', 'Field {{$field}} is not numeric as expected');
        $validator->add('range', '{{$controller_data.class}}[{{$field}}]', 'Field {{$field}} is out of range', array({{$property.range[0]}}, {{$property.range[1]}}));
{{/if}}
{{/if}}
        {{/foreach}}

        if ($validator->validate()) {
            $data = $this->request->getArray('{{$controller_data.class}}', SC_POST);

{{foreach from=$map item=property key=field}}
{{if !isset($property.options) || !in_array('pk', $property.options) || !in_array('once', $property.options)}}
${{$controller_data.class}}->{{$property.mutator}}($data['{{$field}}']);
{{/if}}
            {{/foreach}}

            ${{$controller_data.class}}Mapper->save(${{$controller_data.class}});

            return jipTools::redirect();
        }

        $url = new url('withId');
        $url->add('id', $id);
        $url->setAction($action);

        $this->smarty->assign('form_action', $url->get());
        $this->smarty->assign('errors', $validator->getErrors());
        $this->smarty->assign('{{$controller_data.class}}', ${{$controller_data.class}});
        $this->smarty->assign('isEdit', $isEdit);

        return $this->smarty->fetch('{{$controller_data.module}}/{{$controller_data.name}}.tpl');
    }
}

?>