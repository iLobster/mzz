�����: {$forum->getTitle()}<br />
�����: (<a href="{url route=withId action=newThread id=$forum->getId()}">������� �����</a>)
<table border="1" width="100%">
    <tr>
        <td>��������</td>
        <td>�����</td>
        <td>������</td>
        <td>��������� ���������</td>
    </tr>
    {foreach from=$threads item=thread}
        <tr>
            <td><a href="{url route=withId action=thread id=$thread->getId()}">{$thread->getTitle()}</a></td>
            <td>{$thread->getAuthor()->getLogin()}</td>
            <td>{$thread->getPostsCount()}</td>
            <td>{$thread->getLastPost()->getAuthor()->getLogin()}, {$thread->getLastPost()->getPostDate()|date_format:"%e %B %Y / %H:%M:%S"}</td>
        </tr>
    {/foreach}
</table>
{if $pager->getPagesTotal() > 0}
    <div class="pages">{$pager->toString()}</div>
{/if}