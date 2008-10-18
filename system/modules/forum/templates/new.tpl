{title append="Форум"}
{title append="Новые сообщения"}
{add file="forum.css"}
<div class="forumTopPanel">
    <div class="left"><a href="{url route="default2" action="forum"}">MZZ Forums</a> / Новые сообщения</div>
    <div class="right"><br /></div>
    <div class="clearRight"></div>
</div>

<table border="0" cellpadding="6" cellspacing="1" class="forums">
    <tr>
        <td colspan="4" class="forumCategory">Последние сообщения</td>
    </tr>
    <tr class="forumFields">
        {if not empty($threads)}
            <td class="forumName">Название темы</td>
            <td class="forumLastPostTitle">Последнее сообщение</td>
            <td class="forumCounter">Ответов</td>
            <td class="forumCounter">Просмотров</td>
        {/if}
    </tr>
{foreach from=$threads item="thread"}
    <tr class="forumDetails">
        <td class="forumName hotStatus newPosts forumOddColumn">
        <a href="{url route=withId action=thread id=$thread->getId()}">{$thread->getTitle()}</a>
        {assign var=id value=$thread->getId()}
        {if not empty($pagers.$id)}
            {$pagers.$id->toString('forum/pager.tpl')}
        {/if}
        <p class="forumDescription">by <a href="{url route="withId" action="profile" id=$thread->getAuthor()->getId()}">{$thread->getAuthor()->getUser()->getLogin()}</a></p>
        </td>
        <td class="forumLastPost forumEvenColumn">
        <a href="{url route="withId" action="last" id=$thread->getId()}"><img src="/templates/images/forum/goto.gif" width="14" height="14" alt="перейти в тему" /></a>
        <div class="postDate">
        {$thread->getLastPost()->getPostDate()|date_format:"%e %B %Y <span>%H:%M</span>"}<br />

        by <a href="{url route="withId" action="profile" id=$thread->getLastPost()->getAuthor()->getId()}">{$thread->getLastPost()->getAuthor()->getUser()->getLogin()}</a>
        </div>
        </td>
        <td class="forumCounter forumEvenColumn">{$thread->getPostsCount()}</td>
        <td class="forumCounter forumOddColumn">{if $thread->getViewCount()}{$thread->getViewCount()}{else}0{/if}</td>
    </tr>
{foreachelse}
    <tr>
        <td colspan="4">С момента последнего посещения новых тем не найдено</td>
    </tr>
{/foreach}
</table>
<br />
{if $pager->getPagesTotal() > 1}
    <div class="pages">{$pager->toString()}</div>
{/if}