{if $isEdit}
    <div class="jipTitle">Редактирование форума</div>
{else}
    <div class="jipTitle">Создание форума</div>
{/if}

<form action="{$action}" method="post" onsubmit="return jipWindow.sendForm(this);">
    <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td style='width: 20%;'>{form->caption name="title" value="Название" onError="style=color: red;"}</td>
            <td style='width: 80%;'>{form->text name="title" size="60" value=$forum->getTitle()}{$errors->get('title')}</td>
        </tr>
        <tr>
            <td style='width: 20%;'>{form->caption name="description" value="Описание форума" onError="style=color: red;"}</td>
            <td style='width: 80%;'>{form->text name="description" size="60" value=$forum->getDescription()}{$errors->get('description')}</td>
        </tr>
        <tr>
            <td style='width: 20%;'>{form->caption name="order" value="Порядок сортировки" onError="style=color: red;"}</td>
            <td style='width: 80%;'>{form->text name="order" size="60" value=$forum->getOrder()}{$errors->get('order')}</td>
        </tr>
        <tr>
            <td>{form->submit name="submit" value="Сохранить"} {form->reset jip="true" name="reset" value="Отмена"}</td>
        </tr>
    </table>
</form>