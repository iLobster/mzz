{if $isEdit}
{include file='jipTitle.tpl' title='admin/class.editing'|i18n}
{else}
{include file='jipTitle.tpl' title='admin/class.adding'|i18n}
{/if}
{form action=$form_action method="post" jip=true}
    <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td style='width: 30%;'>{form->caption name="name" value="_ class.name"}</td>
            <td>{form->text name="name" value=$data.name size="60"}{$errors->get('name')}</td>
        </tr>
        <tr>
            <td style='width: 30%;'>{form->caption name="table" value="_ class.table_name"}</td>
            <td>
                {if $isEdit}
                    {$data.table}
                {else}
                    {form->text name="table" value=$data.table size="60"}{$errors->get('table')}
                {/if}
            </td>
        </tr>
        <tr>
            <td>{form->caption name="dest" value="_ dest"}</td>
            <td>{$data.dest}</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>{form->submit name="submit" value="_ simple/save"} {form->reset jip=true name="reset" value="_ simple/cancel"}</td>
        </tr>
    </table>
</form>