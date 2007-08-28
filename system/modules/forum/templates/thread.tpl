<a href="{url route=default2 action=forum}">Форум</a> / <a href="{url route=withId action=list id=$thread->getForum()->getId()}">{$thread->getForum()->getTitle()}</a> / {$thread->getTitle()}
{if $thread->getACL('post')} (<a href="{url route=withId action=post id=$thread->getId()}">Ответить</a>){/if}<br />
<table border="1" width="100%">
    {foreach from=$posts item=post}
        <tr>
            <td><a name="post_{$post->getId()}"></a>{$post->getAuthor()->getLogin()}, <a href="{url route=withId id=$post->getId() action=goto}">{$post->getPostDate()|date_format:"%e %B %Y / %H:%M:%S"}</a>{if $post->getAcl('edit')} <a href="{url route=withId action=edit id=$post->getId()}">Редактировать</a>{/if}</td>
        </tr>
        <tr>
            <td>{$post->getText()}</td>
        </tr>
    {/foreach}
</table>

{if $pager->getPagesTotal() > 0}
    <div class="pages">{$pager->toString()}</div>
{/if}

{load module="forum" action="post" id=$thread->getId() 403handle="manual"}