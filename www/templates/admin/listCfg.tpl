<table>
    <tr>
        <td><strong>���</strong></td>
        <td><strong>��������</strong></td>
    </tr>
    {foreach from=$params item=value key=param}
        <tr>
            <td>{$param}</td>
            <td>{$value}</td>
            <td>
                <a href="{url route="adminCfgEdit" section="admin" id=$data.id name=$param action=editCfg}" class="jipLink"><img src="{$SITE_PATH}/templates/images/edit.gif" alt="������������� ��������" title="������������� ��������" /></a>
                <a href="{url route="adminCfgEdit" section="admin" id=$data.id name=$param action=deleteCfg}" class="jipLink"><img src="{$SITE_PATH}/templates/images/delete.gif" alt="������� ��������" title="������� ��������" /></a>
            </td>
        </tr>
    {foreachelse}
        <tr>
            <td colspan="3">��� ������� ������ �� ���������� �� ������ ���������</td>
        </tr>
    {/foreach}
</table>
<a href="{url route="withId" id=$data.id action=addCfg}" class="jipLink"><img src="{$SITE_PATH}/templates/images/add.gif" alt="�������� ��������" title="�������� ��������" /></a>
<a href="{url route="withId" id=$data.id action=addCfg}" class="jipLink">��������</a>