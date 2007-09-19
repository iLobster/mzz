<table border="1" width="100%">
    {if not empty($threads)}
        <tr>
            <td>��������</td>
            <td>�����</td>
            <td>������</td>
            <td>����������</td>
            <td>��������� ���������</td>
        </tr>
    {/if}
    {foreach from=$threads item=thread}
        <tr>
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
            <td>{$thread->getLastPost()->getAuthor()->getLogin()}, <a href="{url route=withId action=last id=$thread->getId()}">{$thread->getLastPost()->getPostDate()|date_format:"%e %B %Y / %H:%M:%S"}</a><br />{$thread->getLastPost()->getText()|nl2br}</td>
        </tr>
    {foreachelse}
        <tr>
            <td colspan="5">� ������� ���������� ��������� ����� ��� �� �������</td>
        </tr>
    {/foreach}
</table>
{if $pager->getPagesTotal() > 0}
    <div class="pages">{$pager->toString()}</div>
{/if}