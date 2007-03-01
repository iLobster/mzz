{include file='jipTitle.tpl' title="Конфигурация для модуля '$module' в секции '$section'"}
<form method="post" action="{url section="config" action="editCfg" params="$section/$module"}" onsubmit="return mzzAjax.sendForm(this);">
    <table cellspacing="0" cellpadding="0" border="0">
        {foreach from=$configs item=value key=key}
            <tr>
                <td>{$key}</td>
                <td><input type="text" name="config[{$key}]" value="{$value.0.value}"></td>
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