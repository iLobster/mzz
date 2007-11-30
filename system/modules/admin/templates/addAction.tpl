{if $action eq 'addAction'}
    {include file='jipTitle.tpl' title='Добавление действия'}
{else}
    {include file='jipTitle.tpl' title='Редактирование действия'}
{/if}

<form action="{$form_action}" method="post" onsubmit="return jipWindow.sendForm(this);">
    <table width="99%" border="0" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td width="40%">{form->caption name="action[name]" value="Название"}</td>
            <td>{form->text name="action[name]" size="30" value=$defaults->get('name')}{$errors->get('action[name]')}</td>
        </tr>
        {if $action eq 'addAction'}
            <tr>
                <td>{form->caption name="action[dest]" value="Каталог генерации"}</td>
                <td>{form->select name="action[dest]" options=$dests one_item_freeze=1}</td>
            </tr>
        {else}
            {$defaults->get('dest')}
        {/if}
        <tr>
            <td>{form->caption name="action[controller]" value="Контроллер"}</td>
            <td>{form->text name="action[controller]" size="30" value=$defaults->get('controller')}</td>
        </tr>
        <tr>
            <td>{form->caption name="action[title]" value="Заголовок для меню JIP"}</td>
            <td>{form->text name="action[title]" size="30" value=$defaults->get('title')}</td>
        </tr>
        <tr>
            <td>{form->caption name="action[icon]" value="Путь от корня сайта до иконки для меню JIP"}</td>
            <td>{form->text name="action[icon]" size="30" value=$defaults->get('icon')}</td>
        </tr>
        <tr>
            <td>{form->caption name="action[confirm]" value="Сообщение при выполнении данного действия"}</td>
            <td>{form->text name="action[confirm]" size="30" value=$defaults->get('confirm')}</td>
        </tr>
        <tr>
            <td>{form->caption name="action[alias]" value="Алиас"}</td>
            <td>{form->select name="action[alias]" emptyFirst=true options=$aliases value=$defaults->get('alias')}</td>
        </tr>
        <tr>
            <td>{form->caption name="action[inACL]" value="Не регистрировать в ACL"}</td>
            <td>{form->checkbox name="action[inACL]" value=$defaults->get('inACL') values="1|0"}</td>
        </tr>
        <tr>
            <td>{form->caption name="action[jip]" value="Добавить в JIP"}</td>
            <td>{form->checkbox name="action[jip]" value=$defaults->get('jip')}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:center;">{form->submit name="submit" value="Сохранить"} {form->reset jip=true name="reset" value="Отмена"}</td>
        </tr>
    </table>
</form>