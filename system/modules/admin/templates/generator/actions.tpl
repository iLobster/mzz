<?php
//{{$name}} actions config

return array(
{{foreach from=$actionsArray key="actions_name" item="data" name="actionsForeach"}}
    '{{$actions_name}}' => array(
{{foreach from=$data key="k" item="v" name="dataForeach"}}
        '{{$k}}' => '{{$v}}'{{if !$smarty.foreach.dataForeach.last}},
{{/if}}
{{/foreach}}

    ){{if !$smarty.foreach.actionsForeach.last}},
{{/if}}
{{/foreach}}

);
?>