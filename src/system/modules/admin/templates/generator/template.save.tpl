<div class="jipTitle">
    {if $isEdit}Editing{else}Creating{/if} object {{$name}}
</div>

{form action=$form_action method="post" jip=true  class="mzz-jip-form"}
{{foreach from=$map item=property key=field}}
<div class="field{$validator->isFieldRequired('{{$name}}[{{$field}}]', ' required')} {$validator->isFieldError('{{$name}}[{{$field}}]', ' error')}">
    <div class="label">
        {form->caption name="{{$name}}[{{$field}}]" value="{{$field}}"}
    </div>
    <div class="text">
    {{if !isset($property.options) || !in_array('pk', $property.options) || !in_array('once', $property.options)}}
    {form->text name="{{$name}}[{{$field}}]" size="30" value=${{$name}}->{{$property.accessor}}()}
        {if $validator->isFieldError('{{$name}}[{{$field}}]')}<span class="caption error">{$validator->getFieldError('{{$name}}[{{$field}}]')}</span>{/if}
    {{else}}
    {${{$name}}->{{$property.accessor}}()}
    {{/if}}
</div>
</div>
{{/foreach}}
<div class="field buttons">
    <div class="text">
        {form->submit name="submit" value="_ simple/save"} {form->reset jip=true name="reset" value="_ simple/cancel"}
    </div>
</div>
</form>