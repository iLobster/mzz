{add file="prototype.js"}
{add file="prototype_improvements.js"}
{add file="effects.js"}
{add file="dragdrop.js"}
{add file="popup.js"}
{add file="jip.css"}
{add file="jip.js"}

{title append=$message->getTitle()|htmlspecialchars}
{title append="Просмотр сообщения"}

{foreach from=$categories item=category name=cat}
    <a href="{url route=withAnyParam action=list section=message name=$category->getName()}">{$category->getTitle()|htmlspecialchars}</a>
    {if not $smarty.foreach.cat.last} | {/if}
{/foreach}
<br /><br />
<strong>Тема:</strong> {$message->getTitle()|htmlspecialchars}<br />
{if $isSent}
    <strong>Получатель:</strong> {$message->getRecipient()->getLogin()}<br />
{else}
    <strong>Отправитель:</strong> {$message->getSender()->getLogin()}<br />
{/if}
<strong>Текст сообщения:</strong><br />{$message->getText()|htmlspecialchars|nl2br}<br />
<br />
{if not $isSent}
<a href="{url route=withAnyParam section=message action=send name=$message->getSender()->getLogin()}">ответить</a> | 
{/if}
<a href="{url route=withId section=message action=delete id=$message->getId()}" class="jipLink">удалить</a>