{if $action eq 'addAction'}
    {include file='jipTitle.tpl' title='Добавление действия'}
{else}
    {include file='jipTitle.tpl' title='Редактирование действия'}
{/if}

{form action=$form_action method="post" jip=true}
    <table width="99%" border="0" cellpadding="4" cellspacing="0" align="center">
        <tr>
            <td width="40%">{form->caption name="action[name]" value="Название"}</td>
            <td>{form->text name="action[name]" size="30" value=$data.name}{$errors->get('action[name]')}</td>
        </tr>
        <tr>
            <td>Каталог генерации</td>
            <td>{$data.dest}</td>
        </tr>
        <tr>
            <td>{form->caption name="action[controller]" value="Контроллер"}</td>
            <td>{form->text name="action[controller]" size="30" value=$data.controller}</td>
        </tr>
        <tr>
            <td>{form->caption name="action[confirm]" value="Сообщение при выполнении данного действия"}</td>
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
            <td>{form->caption name="action[403handle]" value="Метод проверки прав"}</td>
            <td>{form->select name="action[403handle]" options=$aclMethods value=$data.403handle one_item_freeze=true}</td>
        </tr>
        {if in_array('acl', $plugins) && count($aliases)}
            <tr>
                <td>{form->caption name="action[alias]" value="Алиас для ACL"}</td>
                <td>{form->select name="action[alias]" emptyFirst=true options=$aliases value=$data.alias}</td>
            </tr>
        {/if}

        <tr>
            <td colspan="2" style="text-align:center;">{form->submit name="submit" value="Сохранить"} {form->reset jip=true name="reset" value="Отмена"}</td>
        </tr>
    </table>
</form>