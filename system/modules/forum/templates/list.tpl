Форум: {$forum->getTitle()}<br />
Треды: (<a href="{url route=withId action=newThread id=$forum->getId()}">создать новый</a>)
<table border="1" width="100%">
    <tr>
        <td>Название</td>
        <td>Автор</td>
        <td>Постов</td>
        <td>Последнее сообщение</td>
    </tr>
    {foreach from=$forum->getThreads() item=thread}
        <tr>
            <td><a href="{url route=withId action=thread id=$thread->getId()}">{$thread->getTitle()}</a></td>
            <td>{$thread->getAuthor()->getLogin()}</td>
            <td>{$thread->getPostsCount()}</td>
            <td>{$thread->getLastPostAuthor()->getLogin()}, {$thread->getLastPostDate()|date_format:"%e %B %Y / %H:%M"}</td>
        </tr>
    {/foreach}
</table>