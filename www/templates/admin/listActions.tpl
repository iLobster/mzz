{foreach from=$insert item=item key=id name=insert}
    {if $smarty.foreach.insert.first}
        <font color="green">���� ��������� �����</font>: 
    {/if}
    <b>{$item}</b>{if not $smarty.foreach.insert.last}, {else}.<br />{/if}
{/foreach}
{foreach from=$delete item=item key=id name=delete}
    {if $smarty.foreach.delete.first}
        <font color="red">���� ������� �����</font>: 
    {/if}
    <b>{$item}</b>{if not $smarty.foreach.delete.last}, {else}.<br />{/if}
{/foreach}
<a href="{url section="admin" id=$id action="addAction"}" onClick="return jipWindow.open(this.href);"><img src="{$SITE_PATH}/templates/images/add.gif" alt="�������� ����" /></a><br />
{foreach from=$actions item=action key=key}
    {$key}
    {if not empty($action.title)}
        ({$action.title})
    {/if}
    <a href="{url section="admin" id=$id actionName="$key" action="editAction"}" onClick="return jipWindow.open(this.href);"><img src="{$SITE_PATH}/templates/images/edit.gif" alt="������������� ����" /></a>
    <a href="{url section="admin" id=$id actionName="$key" action="deleteAction"}" onClick="return jipWindow.open(this.href);"><img src="{$SITE_PATH}/templates/images/delete.gif" alt="������� ����" /></a>
    <br />
{/foreach}