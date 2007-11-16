{include file='jipTitle.tpl' title="Конфигурация для модуля $module в секции $section"}
<form method="post" action="{url section="config" action="editCfg" params="$section/$module"}" onsubmit="return jipWindow.sendForm(this);">
<table border="0" width="99%" cellpadding="4" cellspacing="0" class="systemTable">
        {foreach from=$configs item=value key=key}
            <tr>
                <td>{$value.title}</td>
                <td><input type="text" name="config[{$key}]" value="{$value.value}"></td>
            </tr>
        {foreachelse}
            <tr>
                <td>Доступных для конфигурирования параметров нет</td>
            </tr>
        {/foreach}
        {if sizeof($configs)}
            <tr>
                <td colspan="2">
                    <input type="submit" value="Сохранить">
                </td>
            </tr>
        {/if}
    </table>
</form>