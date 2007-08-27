Форум: <a href="{url route=withId action=list id=$thread->getForum()->getId()}">{$thread->getForum()->getTitle()}</a><br />
Тред: {$thread->getTitle()}<br />
<a href="{url route=withId action=post id=$thread->getId()}">Добавить пост</a>

<table border="1" width="100%">
    {foreach from=$posts item=post}
        <tr>
            <td>{$post->getAuthor()->getLogin()}, {$post->getPostDate()|date_format:"%e %B %Y / %H:%M:%S"}{$post->getJip()}</td>
        </tr>
        <tr>
            <td>{$post->getText()}</td>
        </tr>
    {/foreach}
</table>

{if $pager->getPagesTotal() > 0}
    <div class="pages">{$pager->toString()}</div>
{/if}

{load module="forum" action="post" id=$thread->getId()}