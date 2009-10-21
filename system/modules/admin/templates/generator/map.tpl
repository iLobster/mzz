array(
{{foreach from=$map key="field" item="data" name="mapForeach"}}
    '{{$field}}' => array(
        'accessor' => '{{$data.accessor}}',
        'mutator' => '{{$data.mutator}}'{{if isset($data.type)}},
        'type' => '{{$data.type}}'{{/if}}{{if isset($data.range)}},
        'range' => array({{$data.range.0|default:0}}, {{$data.range.1|default:0}}){{/if}}{{if isset($data.options) && $data.options}},
        'options' => array({{foreach from=$data.options item="option" name="optionsForeach"}}'{{$option}}'{{if !$smarty.foreach.optionsForeach.last}}, {{/if}}{{/foreach}}){{/if}}{{if isset($data.additional) && $data.additional}},
        {{foreach from=$data.additional key="additionalKey" item="additionalValue" name="additionalForeach"}}'{{$additionalKey}}' => {{$additionalValue|@var_export:true}}{{if !$smarty.foreach.additionalForeach.last}}, {{/if}}
{{/foreach}}
{{/if}}

    ){{if !$smarty.foreach.mapForeach.last}},
{{/if}}
{{/foreach}}

)