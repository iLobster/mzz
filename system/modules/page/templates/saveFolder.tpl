{if $isEdit}
    <div class="jipTitle">Редактирование папки</div>
{else}
    <div class="jipTitle">Создание папки</div>
{/if}

{form action=$action method="post" jip=true}
    <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td style='width: 30%;'>{form->caption name="name" value="Идентификатор"}</td>
            <td style='width: 70%;'>{form->text name="name" value=$folder->getName() size="40"}{$errors->get('name')}</td>
        </tr>
        <tr>
            <td style='width: 30%;'>{form->caption name="title" value="Название"}</td>
            <td style='width: 70%;'>{form->text name="title" value=$folder->getTitle() size="40"}{$errors->get('title')}</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>{form->submit name="submit" value="Сохранить"} {form->reset jip=true name="reset" value="Отмена"}</td>
        </tr>
    </table>
</form>