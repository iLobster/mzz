{foreach from=$insert item=item key=id name=insert}
    {if $smarty.foreach.insert.first}
        <font color="green">���� ��������� �����</font>: 
    {/if}
    <b>{$item}</b>{if not $smarty.foreach.insert.last}, {else}.<br />{/if}
{foreachelse}
    ����� ������ ��������� �� ����.<br />
{/foreach}
{foreach from=$delete item=item key=id name=delete}
    {if $smarty.foreach.delete.first}
        <font color="red">���� ������� �����</font>: 
    {/if}
    <b>{$item}</b>{if not $smarty.foreach.delete.last}, {else}.<br />{/if}
{foreachelse}
    ������ ������� �� ����.<br />
{/foreach}
<br />�������� ������� ���������.