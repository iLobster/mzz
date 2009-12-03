<div class="jipTitle">
    {if $isEdit}Editing{else}Creating{/if} object {{$name}}
</div>

{form action=$form_action method="post" jip=true}
    <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
        {{foreach from=$map item=property key=field}}
<tr>
            <td>{form->caption name="{{$name}}[{{$field}}]" value="{{$field}}"}</td>
{{if !isset($property.options) || !in_array('pk', $property.options) || !in_array('once', $property.options)}}
            <td>
                {form->text name="{{$name}}[{{$field}}]" size="30" value=${{$name}}->{{$property.accessor}}()}
                {if $validator->isFieldError('{{$name}}[{{$field}}]')}<div class="error">{$validator->getFieldError('{{$name}}[{{$field}}]')}</div>{/if}
            </td>
{{else}}
            <td>{${{$name}}->{{$property.accessor}}()}</td>
{{/if}}
        </tr>
        {{/foreach}}

        <tr>
            <td>&nbsp;</td>
            <td>{form->submit name="submit" value="_ simple/save"} {form->reset jip=true name="reset" value="_ simple/cancel"}</td>
        </tr>
    </table>
</form>