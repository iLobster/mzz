{include file='jipTitle.tpl' title="������������ ��� ������ '$module' � ������ '$section'"}
<form method="post" action="{url section="config" action="editCfg" params="$section/$module"}" onsubmit="return mzzAjax.sendForm(this);">
    <table cellspacing="0" cellpadding="0" border="0">
        {foreach from=$configs item=value key=key}
            <tr>
                <td>{$key}</td>
                <td><input type="text" name="config[{$key}]" value="{$value.0.value}"></td>
            </tr>
        {foreachelse}
            <tr>
                <td>��������� ��� ���������������� ���������� ���</td>
            </tr>
        {/foreach}
        {if sizeof($configs)}
            <tr>
                <td colspan="2">
                    <input type="submit" value="���������">
                </td>
            </tr>
        {/if}
    </table>
</form>