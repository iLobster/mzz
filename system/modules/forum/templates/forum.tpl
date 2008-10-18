{title append="Форум"}
{add file="forum.css"}
<div class="forumTopPanel">
    <div class="left"><a href="{url route="default2" action="forum"}">MZZ Forums</a></div>
    <div class="right"><a href="{url route="default2" action="new"}">новые сообщения</a></div>
    <div class="clearRight"></div>
</div>
{foreach from=$categories item="category" name="cat"}
    <table border="0" cellpadding="6" cellspacing="1" class="forums">
        <tr>
            <td colspan="4" class="forumCategory">{$category->getTitle()}</td>
        </tr>
        <tr class="forumFields">
            <td class="forumName">Название темы</td>
            <td class="forumCounter">Тем</td>
            <td class="forumCounter">Сообщений</td>
            <td class="forumLastPostTitle">Последнее сообщение</td>
        </tr>
        {foreach from=$category->getForums() item="forum"}
            {assign var="id" value=$forum->getId()}
            <tr class="forumDetails">
                <td class="forumName hotStatus {if not empty($new_forums.$id)}new{else}noNew{/if}Threads forumOddColumn">
                <a href="{url route="withId" action="list" id=$forum->getId()}">{$forum->getTitle()}</a>
                {if $forum->getDescription()}<p class="forumDescription">{$forum->getDescription()}</p>{/if}
                </td>
                <td class="forumCounter forumEvenColumn">{$forum->getThreadsCount()}</td>
                <td class="forumCounter forumOddColumn">{$forum->getPostsCount()}</td>
                <td class="forumLastPost forumEvenColumn">
                {if $forum->getLastPost()}
                    <a href="{url route="withId" action="last" id=$forum->getLastPost()->getThread()->getId()}"><strong>{$forum->getLastPost()->getThread()->getTitle()|truncate:30|htmlspecialchars}</strong></a>

                    <a href="{url route="withId" action="last" id=$forum->getLastPost()->getThread()->getId()}"><img src="{$SITE_PATH}/templates/images/forum/goto.gif" width="14" height="14" alt="перейти в тему" /></a>
                    <div class="postDate">
                        {$forum->getLastPost()->getAuthor()->getUser()->getLogin()}, {$forum->getLastPost()->getPostDate()|date_format:"%e %B %Y <span>%H:%M</span>"}
                    </div>
                {else}
                    Нет сообщений
                {/if}
                </td>
            </tr>
        {/foreach}
    </table>
        {if not $smarty.foreach.cat.last}
            <br />
        {/if}
{/foreach}