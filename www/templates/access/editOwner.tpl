<div id="jipTitle">
<div class="jipMove">&nbsp;</div>
��������� ���� �� ������ ���� <b>{$class}</b> ������� <b>{$section}</b> ��� ��������� �������
</div>

<form action="{url}" method="post" onsubmit="return sendFormWithAjax(this);return false;">
<table border="0" width="100%" cellpadding="0" cellspacing="1">
        {foreach from=$actions item=action}
            <tr>
                <td>{$action}</td>
                <td><input type="checkbox" name="access[{$action}][allow]" value="1" {if not empty($acl.$action.allow)}checked="checked"{/if} /><input type="checkbox" name="access[{$action}][deny]" value="1" {if not empty($acl.$action.deny)}checked="checked"{/if} /></td>
            </tr>
        {/foreach}
        <tr>
            <td><input type="submit" value="���������� �����"></td>
            <td><input type="reset" value="�����"></td>
        </tr>
</table>
</form>