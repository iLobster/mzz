{include file='jipTitle.tpl' title="������, �������� � ������ '`$data.name`'"}
<form action="{url route="withId" section="admin" id=$data.id action="addClassToSection"}" method="POST" onsubmit="return mzzAjax.sendForm(this);">
    <table width="99%" cellpadding="4" cellspacing="0" class="systemTable">
        <tr>
            <td>&nbsp;</td>
            <td><strong>�����</strong></td>
            <td><strong>������</strong></td>
        </tr>
        {foreach from=$list item=current key=key}
            <tr>
                <td width="5%"><input type="checkbox" {if not empty($current.disabled)}disabled="1"{else}name="class[{$key}]"{/if} {if not empty($current.checked)}checked="checked"{/if} value="1" /></td>
                <td width="25%">{$current.c_name}</td>
                <td width="70%">{$current.m_name}</td>
            </tr>
        {/foreach}
        <tr>
            <td colspan="3"><input type="submit" value="���������"> <input type="reset" value="������" onclick="javascript: jipWindow.close();"></td>
        </tr>
    </table>
</form>