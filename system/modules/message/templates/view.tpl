{add file="prototype.js"}
{add file="prototype_improvements.js"}
{add file="effects.js"}
{add file="dragdrop.js"}
{add file="popup.js"}
{add file="jip.css"}
{add file="jip.js"}

{title append=$message->getTitle()|htmlspecialchars}
{title append="�������� ���������"}

{foreach from=$categories item=category name=cat}
    <a href="{url route=withAnyParam action=list section=message name=$category->getName()}">{if $message->getCategory()->getId() eq $category->getId()}<b>{/if}{$category->getTitle()|htmlspecialchars}{if $message->getCategory()->getId() eq $category->getId()}</b>{/if}</a>
    {if not $smarty.foreach.cat.last} | {/if}
{/foreach}
<br /><br />
<strong>����:</strong> {$message->getTitle()|htmlspecialchars}<br />
{if $isSent}
    <strong>����������:</strong> {$message->getRecipient()->getLogin()}<br />
{else}
    <strong>�����������:</strong> {$message->getSender()->getLogin()}<br />
{/if}
<strong>����� ���������:</strong><br />{$message->getText()|htmlspecialchars|nl2br}<br />
<br />
{if not $isSent}
<a href="{url route=withAnyParam section=message action=send name=$message->getSender()->getLogin()}" class="jipLink">��������</a> | 
{/if}
<a href="{url route=withId section=message action=delete id=$message->getId()}" class="jipLink">�������</a>