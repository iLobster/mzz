{if $isEdit}
{include file='jipTitle.tpl' title='admin/module.editing'|i18n}
{else}
{include file='jipTitle.tpl' title='admin/module.adding'|i18n}
{/if}
{form action=$form_action method="post" jip=true}
    <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td style="width: 30%;">{form->caption name="name" value="_ module.name"}</td>
            <td>{if $nameRO}
                    {$data.name}
                {else}
                    {form->text name="name" size="30" value=$data.name}{$errors->get('name')}
                {/if}
            </td>
        </tr>
        <tr>
            <td>{form->caption name="dest" value="_ module.dest"}</td>
            <td>
                {if !$isEdit}
                    {$data.dest}
                {else}
                    {form->select name="dest" options=$dests one_item_freeze=1}{$errors->get('dest')}
                {/if}
            </td>
        </tr>
        <tr>
            <td style="width: 30%;">{form->caption name="title" value="_ module.title"}</td>
            <td>{form->text name="title" size="30" value=$data.title}{$errors->get('title')}</td>
        </tr>
        <tr>
            <td style="width: 30%;">{form->caption name="icon" value="_ module.icon"}</td>
            <td>{form->text name="icon" size="30" value=$data.icon}{$errors->get('icon')}</td>
        </tr>
        <tr>
            <td style="width: 30%;">{form->caption name="order" value="_ module.order"}</td>
            <td>{form->text name="order" size="30" value=$data.order|default:"0"}{$errors->get('order')}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:center;">{form->submit name="submit" value="_ simple/save"} {form->reset jip=true name="reset" value="_ simple/cancel"}</td>
        </tr>
    </table>
</form>