{add file="prototype.js"}
{add file="prototype_improvements.js"}
{add file="effects.js"}
{add file="dragdrop.js"}
{add file="popup.js"}
{add file="jip.css"}
{add file="jip.js"}

{title append=$messageCategory->getTitle()|htmlspecialchars}
{title append="Список сообщений"}

{foreach from=$categories item=category name=cat}
    {if $messageCategory->getName() ne $category->getName()}<a href="{url route=withAnyParam action=list section=message name=$category->getName()}">{$category->getTitle()|htmlspecialchars}</a>{else}{$category->getTitle()|htmlspecialchars}{/if}
    {if not $smarty.foreach.cat.last} | {/if}
{/foreach}
<br /><br />
<a href="{url route=default2 action=send section=message}" class="jipLink">отправить сообщение</a>
<br /><br />

<table border="0" width="99%" cellpadding="4" cellspacing="0" class="systemTable">
    <tr align="center">
        <td><strong>id</strong></td>
        <td><strong>сообщение</strong></td>
        <td><strong>{if $isSent}кому{else}от{/if}</strong></td>
        <td><strong>дата</strong></td>
    </tr>
    {foreach from=$messages item=message}
        <tr align="center">
            <td>{$message->getId()}</td>
            <td><a href="{url route=withId action=view section=message id=$message->getId()}">{if not $message->getWatched()}<b>{/if}{$message->getTitle()|htmlspecialchars}{if not $message->getWatched()}</b>{/if}</a>{$message->getJip()}</td>
            <td>{if $isSent}{$message->getRecipient()->getLogin()}{else}<a href="{url route=withAnyParam action=send section=message name=$message->getSender()->getLogin()}">{$message->getSender()->getLogin()}</a>{/if}</td>
            <td>{$message->getTime()|date_format:"%H:%M:%S %e-%m-%Y"}</td>
        </tr>
    {/foreach}
</table>