<a href="{url route=default2 action=forum}">Форум</a> / {$forum->getTitle()}
{if $forum->getAcl('newThread')} (<a href="{url route=withId action=newThread id=$forum->getId()}">Начать новую тему</a>){/if}<br />
<table border="1" width="100%">
    <tr>
        <td>&nbsp;</td>
        <td>Название</td>
        <td>Автор</td>
        <td>Постов</td>
        <td>Просмотров</td>
        <td>Последнее сообщение</td>
    </tr>
    {foreach from=$threads item=thread}
        <tr>
            <td>
                {if $thread->isNew()}
                    <span style="color: red;">new!!!</span>
                {else}
                    &nbsp;
                {/if}
                {if $thread->isPopular()}
                    <span style="color: blue;">popular!!!</span>
                {else}
                    &nbsp;
                {/if}
            </td>
            <td>
                <a href="{url route=withId action=thread id=$thread->getId()}">{$thread->getTitle()}</a>
                {assign var=id value=$thread->getId()}
                {if not empty($pagers.$id)}
                    {$pagers.$id->toString('forum/pager.tpl')}
                {/if}
            </td>
            <td>{$thread->getAuthor()->getLogin()}</td>
            <td>{$thread->getPostsCount()}</td>
            <td>{if $thread->getViewCount()}{$thread->getViewCount()}{else}0{/if}</td>
            <td>{$thread->getLastPost()->getAuthor()->getLogin()}, <a href="{url route=withId action=last id=$thread->getId()}">{$thread->getLastPost()->getPostDate()|date_format:"%e %B %Y / %H:%M:%S"}</a></td>
        </tr>
    {/foreach}
</table>
{if $pager->getPagesTotal() > 0}
    <div class="pages">{$pager->toString()}</div>
{/if}