<a href="{url route=default2 action=forum}">�����</a> / {$forum->getTitle()}
{if $forum->getAcl('newThread')} (<a href="{url route=withId action=newThread id=$forum->getId()}">������ ����� ����</a>){/if}<br />
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
            <td>{$thread->getLastPost()->getAuthor()->getLogin()}, <a href="{url route=withId action=last id=$thread->getId()}">{$thread->getLastPost()->getPostDate()|date_format:"%e %B %Y / %H:%M:%S"}</a></td>
        </tr>
    {/foreach}
</table>
{if $pager->getPagesTotal() > 0}
    <div class="pages">{$pager->toString()}</div>
{/if}