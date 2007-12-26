{if not $isEdit}
    {include file='jipTitle.tpl' title='Создание поля'}
{else}
    {include file='jipTitle.tpl' title="Редактирование поля '`$field_name`'"}
{/if}
{literal}
<script type="text/javascript">
function mapAutoCompleteMethods(input)
{
    var value = ($F(input)).capitalize();

    var parts = value.split('_'), len = parts.length;
    if (len == 1) {
        var camelized = parts[0];
    } else {
        var camelized = value.charAt(0) == '_'
          ? parts[0].charAt(0).toUpperCase() + parts[0].substring(1)
          : parts[0];

        for (var i = 1; i < len; i++)
          camelized += parts[i].charAt(0).toUpperCase() + parts[i].substring(1);
    }

    $('saveMap_accessor').value = 'get' + camelized;
    $('saveMap_mutator').value = 'set' + camelized;

}
</script>
{/literal}

<form action="{$form_action}" method="post" onsubmit="return jipWindow.sendForm(this);">
    <table width="99%" border="0" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td width="30%">{form->caption name="field[name]" value="Имя"}</td>
            <td>{form->text name="field[name]" size="30" value=$defaults->get('name') onkeyup="mapAutoCompleteMethods(this);" freeze=$isEdit}{$errors->get('field[name]')}</td>
        </tr>
        <tr>
            <td>{form->caption name="field[accessor]" value="Accessor (получение)"}</td>
            <td>{form->text name="field[accessor]" size="30" id="saveMap_accessor" value=$defaults->get('accessor')}{$errors->get('field[accessor]')}</td>
        </tr>
        <tr>
            <td>{form->caption name="field[mutator]" value="Mutator (изменение)"}</td>
            <td>{form->text name="field[mutator]" size="30" id="saveMap_mutator" value=$defaults->get('mutator')}{$errors->get('field[mutator]')}</td>
        </tr>
        <tr>
            <td>{form->caption name="field[once]" value="Только чтение"}</td>
            <td>{form->checkbox name="field[once]" value=$defaults->get('once')}{$errors->get('field[once]')}</td>
        </tr>
        <tr>
            <td>{form->caption name="field[orderBy]" value="Порядок сортировки"}</td>
            <td>{form->text name="field[orderBy]" size="30" value=$defaults->get('orderBy')}{$errors->get('field[orderBy]')}</td>
        </tr>
        <tr>
            <td>{form->caption name="field[orderByDirection]" value="Направление сортировки"}</td>
            <td>{form->select name="field[orderByDirection]" options=$directions value=$defaults->get('orderByDirection') emptyFirst=true}{$errors->get('field[orderByDirection]')}</td>
        </tr>
        <tr>
            <td colspan="2">{form->submit name="submit" value="Сохранить"} {form->reset jip=true name="reset" value="Отмена"}</td>
        </tr>
    </table>
</form>