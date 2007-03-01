{include file='jipTitle.tpl' title="Классы, входящие в раздел '`$data.name`'"}
<form action="{url route="withId" section="admin" id=$data.id action="addClassToSection"}" method="POST" onsubmit="return mzzAjax.sendForm(this);">
    <table width="99%" border="0" cellpadding="5" cellspacing="0" align="center">
        {foreach from=$list item=current key=key}
            <tr>
                <td><input type="checkbox" {if not empty($current.disabled)}disabled="1"{else}name="class[{$key}]"{/if} {if not empty($current.checked)}checked="checked"{/if} value="1" /></td>
                <td>{$current.c_name}</td>
                <td>{$current.m_name}</td>
            </tr>
        {/foreach}
        <tr>
            <td colspan="3"><input type="submit" value="Сохранить"> <input type="reset" value="Отмена" onclick="javascript: jipWindow.close();"></td>
        </tr>
    </table>
</form>