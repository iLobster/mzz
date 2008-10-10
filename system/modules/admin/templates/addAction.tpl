{if $action eq 'addAction'}
    {include file='jipTitle.tpl' title='Добавление действия'}
{else}
    {include file='jipTitle.tpl' title='Редактирование действия'}
{/if}

<form action="{$form_action}" method="post" onsubmit="return jipWindow.sendForm(this);">
    <table width="99%" border="0" cellpadding="4" cellspacing="0" align="center">
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
            <td>{form->caption name="action[403handle]" value="Метод проверки прав"}</td>
            <td>{form->select name="action[403handle]" emptyFirst="default (обычный)" options=$aclMethods value=$defaults->get('403handle')}</td>
        </tr>
        <tr>
            <td>{form->caption name="action[alias]" value="Алиас для ACL"}</td>
            <td>{form->select name="action[alias]" emptyFirst=true options=$aliases value=$defaults->get('alias')}</td>
        </tr>
        <tr>
            <td>{form->caption name="action[jip]" value="Добавить в JIP"}</td>
            <td>{form->checkbox name="action[jip]" value=$defaults->get('jip')}</td>
        </tr>
        <tr>
            <td>{form->caption name="action[lang]" value="Мультиязычный экшн"}</td>
            <td>{form->checkbox name="action[lang]" value=$defaults->get('lang')}</td>
        </tr>
        {if $action eq 'addAction'}
        <tr>
            <td>{form->caption name="action[tpl_as_controller]" value="Назвать пассивный шаблон как контроллер"}</td>
            <td>{form->checkbox name="action[tpl_as_controller]" value=0}</td>
        </tr>
        {/if}
        <tr>
            <td colspan="2" style="text-align:center;">{form->submit name="submit" value="Сохранить"} {form->reset jip=true name="reset" value="Отмена"}</td>
        </tr>
    </table>
</form>