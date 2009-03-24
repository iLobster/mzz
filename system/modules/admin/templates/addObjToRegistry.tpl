{if $action eq 'addObjToRegistry'}
{include file='jipTitle.tpl' title='Добавление объекта в реестр доступа'}
{else}
{include file='jipTitle.tpl' title='Редактирование объекта в реестре доступа'}
{/if}

{form action=$form_action method="post" jip=true}
    <table border="0" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td>{form->caption name="class" value="Класс"}</td>
            <td>{form->select name="class" emptyFirst=true id="addobj_class" style="width: 150px;" options=$classes}</td>
        </tr>
        <tr>
            <td colspan="4">{if $errors->has('class')}<br />{$errors->get('class')}{/if}</td>
        </tr>
        <tr>
            <td colspan=4 style="text-align:center;">{form->submit name="submit" value="Сохранить"} {form->reset jip=true name="reset" value="Отмена"}</td>
        </tr>
    </table>
</form>