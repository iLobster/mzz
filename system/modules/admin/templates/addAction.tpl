{if $isEdit}
    {include file='jipTitle.tpl' title='admin/action.editing'|i18n}
{else}
    {include file='jipTitle.tpl' title='admin/action.adding'|i18n}
{/if}

{form action=$form_action method="post" jip=true}
    <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td style='width: 30%;'>{form->caption name="action[name]" value="_ action.name"}</td>
            <td>{form->text name="action[name]" size="30" value=$data.name}{$errors->get('action[name]')} (<a href="#" onclick="return fillUpEditAclForm();">editAcl</a>)</td>
        </tr>
        <tr>
            <td>{_ dest}</td>
            <td>{$data.dest}</td>
        </tr>
        <tr>
            <td>{form->caption name="action[controller]" value="_ action.controller"}</td>
            <td>{form->text name="action[controller]" size="30" value=$data.controller}</td>
        </tr>
        <tr>
            <td>{form->caption name="action[confirm]" value="_ action.confirm"}</td>
            <td>{form->text name="action[confirm]" size="30" value=$data.confirm}</td>
        </tr>
        {if in_array('jip', $plugins)}
            <tr>
                <td>{form->caption name="action[jip]" value="Добавить в JIP"}</td>
                <td>{form->checkbox name="action[jip]" value=$data.jip}</td>
            </tr>
            <tr>
                <td>{form->caption name="action[title]" value="Заголовок для меню JIP"}</td>
                <td>{form->text name="action[title]" size="30" value=$data.title}</td>
            </tr>
            <tr>
                <td>{form->caption name="action[icon]" value="Путь от корня сайта до иконки для меню JIP"}</td>
                <td>{form->text name="action[icon]" size="30" value=$data.icon}</td>
            </tr>
        {/if}
        <tr>
            <td>{form->caption name="action[403handle]" value="_ action.acl_type"}</td>
            <td>{form->select name="action[403handle]" options=$aclMethods value=$data.403handle one_item_freeze=true}</td>
        </tr>
        {if in_array('acl', $plugins) && count($aliases)}
            <tr>
                <td>{form->caption name="action[alias]" value="Алиас для ACL"}</td>
                <td>{form->select name="action[alias]" emptyFirst=true options=$aliases value=$data.alias}</td>
            </tr>
        {/if}

        <tr>
            <td>CRUD</td>
            <td>{form->select name="action[crud]" options=$crudList value=none}</td>
        </tr>

        <tr>
            <td>&nbsp;</td>
            <td>{form->submit name="submit" value="_ simple/save"} {form->reset jip=true name="reset" value="_ simple/cancel"}</td>
        </tr>
    </table>
</form>