{include file='jipTitle.tpl' title="������, �������� � ������ '`$data.name`'"}
<form action="{url route="withId" section="admin" id=$data.id action="addModuleToSection"}" method="POST" onsubmit="return jipWindow.sendForm(this);">
    <table width="99%" cellpadding="4" cellspacing="0" class="systemTable">
        <tr>
            <td>&nbsp;</td>
            <td><strong>������</strong></td>
        </tr>
        {foreach from=$list item=current key=key}
            <tr>
                <td width="5%">
                    {assign var=name value="module[`$key`]"}
                    {form->checkbox name=$name  value=$current.checked}
                </td>
                <td width="70%">{$current.m_name}</td>
            </tr>
        {/foreach}
        <tr>
            <td colspan="3"><input type="submit" value="���������"> <input type="reset" value="������" onclick="javascript: jipWindow.close();"></td>
        </tr>
    </table>
</form>