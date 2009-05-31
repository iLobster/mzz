<div class="jipTitle">
    {if $isEdit}Editing{else}Creating{/if} object {{$controller_data.class}}
</div>

{form action=$form_action method="post" jip=true}
    <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
        {{foreach from=$map item=property key=field}}
<tr>
            <td>{form->caption name="{{$controller_data.class}}[{{$field}}]" value="{{$field}}"}</td>
            <td>{form->text name="{{$controller_data.class}}[{{$field}}]" size="30" value=${{$controller_data.class}}->{{$property.accessor}}()}{$errors->get('{{$controller_data.class}}[{{$field}}]')}</td>
        </tr>
        {{/foreach}}

        <tr>
            <td>&nbsp;</td>
            <td>{form->submit name="submit" value="_ simple/save"} {form->reset jip=true name="reset" value="_ simple/cancel"}</td>
        </tr>
    </table>
</form>