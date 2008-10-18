{title append="Форум"}
{title append=$forum->getTitle()}
{add file="forum.css"}
<div class="forumTopPanel">
    <div class="left"><a href="{url route="default2" action="forum"}">MZZ Forums</a> / {$forum->getTitle()}</div>
    <div class="right"><a href="{url route="default2" action="new"}">новые сообщения</a></div>
    <div class="clearRight"></div>
</div>

<table border="0" cellpadding="6" cellspacing="1" class="forums">
    <tr>
        <td colspan="4" class="forumCategory">
        {if $forum->getAcl('newThread')}<span><a href="{url route="withId" action="newThread" id=$forum->getId()}">Начать новую тему</a></span>{/if}
        {$forum->getTitle()}
        </td>
    </tr>
    <tr class="forumFields">
        <td class="threadName">Название темы</td>
        <td class="threadLastPostTitle">Последнее сообщение</td>
        <td class="forumCounter">Ответов</td>
        <td class="forumCounter">Просмотров</td>
    </tr>
{foreach from=$stickys item="thread"}
    <tr class="forumDetails">
        <td class="threadName hotStatus stickThread forumOddColumn">
        <a href="{url route=withId action=thread id=$thread->getId()}">{$thread->getTitle()}</a>
        {assign var=id value=$thread->getId()}
        {if not empty($pagers.$id)}
            {$pagers.$id->toString('forum/pager.tpl')}
        {/if}
        <p class="forumDescription">by <a href="{url route="withId" action="profile" id=$thread->getAuthor()->getId()}">{$thread->getAuthor()->getUser()->getLogin()}</a></p>

        </td>
        <td class="threadLastPost forumEvenColumn">
        <a href="{url route="withId" action="last" id=$thread->getId()}"><img src="{$SITE_PATH}/templates/images/forum/goto.gif" width="14" height="14" alt="перейти в тему" /></a>
        <div class="postDate">
        {$thread->getLastPost()->getPostDate()|date_format:"%e %B %Y <span>%H:%M</span>"}<br />

        by <a href="{url route="withId" action="profile" id=$thread->getLastPost()->getAuthor()->getId()}">{$thread->getLastPost()->getAuthor()->getUser()->getLogin()}</a>
        </div>
        </td>
        <td class="forumCounter forumEvenColumn">{$thread->getPostsCount()}</td>
        <td class="forumCounter forumOddColumn">{if $thread->getViewCount()}{$thread->getViewCount()}{else}0{/if}</td>
    </tr>
{/foreach}
{foreach from=$threads item="thread"}
    <tr class="forumDetails">
        <td class="threadName hotStatus {if $thread->isNew() || $thread->isPopular()}new{else}noNew{/if}Posts forumOddColumn">
        <a href="{url route=withId action=thread id=$thread->getId()}">{$thread->getTitle()}</a>
        {assign var=id value=$thread->getId()}
        {if not empty($pagers.$id)}
            {$pagers.$id->toString('forum/pager.tpl')}
        {/if}
        <p class="forumDescription">by <a href="{url route="withId" action="profile" id=$thread->getAuthor()->getId()}">{$thread->getAuthor()->getUser()->getLogin()}</a></p>
        </td>
        <td class="threadLastPost forumEvenColumn">
        <a href="{url route="withId" action="last" id=$thread->getId()}"><img src="{$SITE_PATH}/templates/images/forum/goto.gif" width="14" height="14" alt="перейти в тему" /></a>
        <div class="postDate">
        {$thread->getLastPost()->getPostDate()|date_format:"%e %B %Y <span>%H:%M</span>"}<br />

        by <a href="{url route="withId" action="profile" id=$thread->getLastPost()->getAuthor()->getId()}">{$thread->getLastPost()->getAuthor()->getUser()->getLogin()}</a>
        </div>
        </td>
        <td class="forumCounter forumEvenColumn">{$thread->getPostsCount()}</td>
        <td class="forumCounter forumOddColumn">{if $thread->getViewCount()}{$thread->getViewCount()}{else}0{/if}</td>
    </tr>
{/foreach}
</table>

<br />
{if $pager->getPagesTotal() > 1}
    <div class="pages">{$pager->toString()}</div>
{/if}