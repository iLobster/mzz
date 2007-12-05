<div class="jipTitle">Конфигурация для модуля {$module} в секции {$section}</div>

<form method="post" action="{url section="config" action="editCfg" params="$section/$module"}" onsubmit="return jipWindow.sendForm(this);">
<table border="0" width="99%" cellpadding="4" cellspacing="0" class="systemTable">
        {foreach from=$properties item="value" key="key"}
            <tr>
                <td>{$value.title}</td>
                <td><input type="text" name="config[{$key}]" value="{if $value.value == ''}{$value.default}{else}{$value.value}{/if}"></td>
            </tr>
        {foreachelse}
            <tr>
                <td>Доступных для конфигурирования параметров нет</td>
            </tr>
        {/foreach}
        {if sizeof($properties)}
            <tr>
                <td colspan="2">
                    {form->submit name="submit" value="Сохранить"}
                </td>
            </tr>
        {/if}
    </table>
</form>