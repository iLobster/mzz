<div class="jipTitle">{if $isEdit}Редактирование{else}Создание{/if}</div>
<form action="{$action}" method="post" onsubmit="return jipWindow.sendForm(this);">
    <table border="0" cellpadding="0" cellspacing="1" width="99%">
        <tr>
            <td>{form->caption name="title" value="Заголовок:"}</td>
            <td>{form->text name="title" size="60" value=$item->getTitle()}{$errors->get('title')}</td>
        <tr>
        <tr>
            <td>{form->caption name="url" value="Ссылка:"}</td>
            <td>{form->text name="url" size="60" value=$item->getPropertyValue('url')}{$errors->get('url')}</td>
        <tr>
        <tr>
            <td>{form->submit name="submit" value="Сохранить"}</td><td>{form->reset jip=true name="reset" value="Отмена"}</td>
        </tr>
    </table>
</form>