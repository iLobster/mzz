<div class="jipTitle">Конфигурация для модуля {$module} в секции {$section}</div>
<form method="post" action="{url section="config" action="editCfg" params="$section/$module"}" onsubmit="return jipWindow.sendForm(this);">
<table border="0" width="99%" cellpadding="4" cellspacing="0" class="systemTable">
        {foreach from=$configs item=value key=key}
            <tr>
                <td>{form->caption name=key value=$value.title}</td>
                <td>{form->text name="config[$key]" value=$value.value} {$errors->get("config[$key]")}</td>
            </tr>
        {foreachelse}
            <tr>
                <td>Доступных для конфигурирования параметров нет</td>
            </tr>
        {/foreach}
        {if sizeof($configs)}
            <tr>
                <td colspan="2">
                    {form->submit name="submit" value="Сохранить"}
                </td>
            </tr>
        {/if}
    </table>
</form>