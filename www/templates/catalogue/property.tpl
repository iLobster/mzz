<div class="jipTitle">{if $isEdit}Редактирование свойства{else}Создание свойства{/if}</div>
<form action="{$action}" method="post" onsubmit="return jipWindow.sendForm(this);">
    <table border="0" cellpadding="0" cellspacing="1" width="100%">
        <tr>
            <td><strong>{form->caption name="title" value="Заголовок:" onError='style="color: red;"' onRequired='<span style="color: red; font-size: 150%;">*</span> '}</strong></td>
            <td>{form->text name="title" size="60" value=$title onError="style=border: red 1px solid;"}{$errors->get('title')}</td>
        </tr>
        <tr>
            <td><strong>Имя:</strong></td>
            <td>{form->text name="name" size="60" value=$name}{$errors->get('name')}</td>
        </tr>
        <tr>
            <td><strong>Тип:</strong></td>
            <td>{form->select name="type" options=$types value=$type}{$errors->get('type')}</td>
        </tr>
        <tr>
            <td>{form->submit name="submit" value="Сохранить"}</td><td>{form->reset onclick="javascript: jipWindow.close();" name="reset" value="Отмена"}</td>
        </tr>
    </table>
</form>