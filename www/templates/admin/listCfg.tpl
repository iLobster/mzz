{include file='jipTitle.tpl' title="����� ������������"}

<table width="99%" cellpadding="4" cellspacing="0"  class="list">
    <tr>
        <td colspan="3"><a href="{url route="withId" id=$data.id action=addCfg}" class="jipLink">�������� ����� �����</a></td>
    </tr>
    <tr>
        <td><strong>���</strong></td>
        <td colspan="2"><strong>��������</strong></td>
    </tr>
    {foreach from=$params item=value key=param}
        <tr>
            <td width="20%">{$param}</td>
            <td width="75%">{$value}</td>
            <td width="5%">
                <a href="{url route="adminCfgEdit" section="admin" id=$data.id name=$param action=editCfg}" class="jipLink"><img src="{$SITE_PATH}/templates/images/edit.gif" alt="������������� ��������" title="������������� ��������" /></a>
                <a href="{url route="adminCfgEdit" section="admin" id=$data.id name=$param action=deleteCfg}" class="jipLink"><img src="{$SITE_PATH}/templates/images/delete.gif" alt="������� ��������" title="������� ��������" /></a>
            </td>
        </tr>
    {foreachelse}
        <tr>
            <td colspan="3" style="color: #999;">��� ������� ������ �� ���������� �� ������ ���������</td>
        </tr>
    {/foreach}

</table>