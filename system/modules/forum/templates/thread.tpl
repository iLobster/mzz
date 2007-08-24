Форум: <a href="{url route=withId action=list id=$thread->getForum()->getId()}">{$thread->getForum()->getTitle()}</a><br />
Тред: {$thread->getTitle()}

<table border="1" width="100%">
    {foreach from=$thread->getPosts() item=post}
        <tr>
            <td>{$post->getAuthor()->getLogin()}, {$post->getPostDate()|date_format:"%e %B %Y / %H:%M:%S"}</td>
        </tr>
        <tr>
            <td>{$post->getText()}</td>
        </tr>
    {/foreach}
</table>