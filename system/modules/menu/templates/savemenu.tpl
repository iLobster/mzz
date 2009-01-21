<div class="jipTitle">{if $isEdit}Редактирование{else}Создание{/if}</div>
{form action=$action method="post" jip=true}
    <table border="0" cellpadding="0" cellspacing="1" width="99%">
        <tr>
            <td>{form->caption name="name" value="Имя:"}</td>
            <td>{form->text name="name" size="60" value=$menu->getName()} {$errors->get('name')}</td>
        <tr>
        <tr>
            <td>{form->submit name="submit" value="Сохранить"}</td><td>{form->reset jip="true" name="reset" value="Отмена"}</td>
        </tr>
    </table>
</form>