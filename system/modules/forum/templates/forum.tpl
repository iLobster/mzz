{foreach from=$categories item=category name=cat}
    <table border="1" width="100%">
        <tr>
            <td colspan=4 style="background-color: #bbb;">{$category->getTitle()}</td>
        </tr>
        <tr>
            <td>Форум</td>
            <td>Тем</td>
            <td>Постов</td>
            <td>Последний пост</td>
        </tr>
        {foreach from=$category->getForums() item=forum}
            <tr>
                <td><a href="{url route=withId action=list id=$forum->getId()}">{$forum->getTitle()}</a>{if $forum->getDescription()}<br /><font size="1px"><b>{$forum->getDescription()}</b></font>{/if}</td>
                <td>{$forum->getThreadsCount()}</td>
                <td>{$forum->getPostsCount()}</td>
                <td>{if $forum->getLastPost()->getId()}<a href="{url route=withId action=thread id=$forum->getLastPost()->getThread()->getId()}">{$forum->getLastPost()->getThread()->getTitle()}</a><br />{$forum->getLastPost()->getThread()->getAuthor()->getLogin()}, {$forum->getLastPost()->getThread()->getPostDate()|date_format:"%e %B %Y / %H:%M:%S"}{else}Постов нет{/if}</td>
            </tr>
        {/foreach}
    </table>
        {if not $smarty.foreach.cat.last}
            <br />
        {/if}
{/foreach}