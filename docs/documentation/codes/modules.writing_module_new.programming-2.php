{title append=$messageCategory->getTitle()|htmlspecialchars}
{title append="������ ���������"}

{foreach from=$categories item=category name=cat}
    {if $messageCategory->getName() ne $category->getName()}<a href="{url route=withAnyParam action=list section=message name=$category->getName()}">{$category->getTitle()|htmlspecialchars}</a>{else}{$category->getTitle()|htmlspecialchars}{/if}
    {if not $smarty.foreach.cat.last} | {/if}
{/foreach}
<table border="0" width="99%" cellpadding="4" cellspacing="0" class="systemTable">
    <tr align="center">
        <td><strong>id</strong></td>
        <td><strong>���������</strong></td>
        <td><strong>��</strong></td>
        <td><strong>����</strong></td>
    </tr>
    {foreach from=$messages item=message}
        <tr align="center">
            <td>{$message->getId()}</td>
            <td><a href="{url route=withId action=view section=message id=$message->getId()}">{$message->getTitle()|htmlspecialchars}</td>
            <td>{if $isSent}{$message->getRecipient()->getLogin()}{else}<a href="{url route=withAnyParam action=send section=message name=$message->getSender()->getLogin()}">{$message->getSender()->getLogin()}</a>{/if}</td>
            <td>{$message->getTime()|date_format:"%H:%M:%S %e-%m-%Y"}</td>
        </tr>
    {/foreach}
</table>