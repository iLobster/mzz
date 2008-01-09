{title append="Форум"}
{title append="Новые сообщения"}

<a href="{url route="default2" action="forum"}">Форум</a> / Новые сообщения

<table border="0" cellpadding="0" cellspacing="0" width="100%">
    {if not empty($threads)}
        <tr style="background-color: #EFF2F5;">
            <td style="padding: 5px; text-align: center; border-bottom: 1px solid #DEE4EB;">Название</td>
            <td style="padding: 5px; text-align: center; border-bottom: 1px solid #DEE4EB;">Автор</td>
            <td style="padding: 5px; text-align: center; border-bottom: 1px solid #DEE4EB;">Постов</td>
            <td style="padding: 5px; text-align: center; border-bottom: 1px solid #DEE4EB;">Просмотров</td>
            <td style="padding: 5px; text-align: center; border-bottom: 1px solid #DEE4EB;">Последнее сообщение</td>
        </tr>
    {/if}
    {foreach from=$threads item="thread"}
        <tr>
            <td style="padding: 5px; text-align: center;">
                <a href="{url route="withId" action="thread" id=$thread->getId()}">{$thread->getTitle()}</a>
                {assign var="id" value=$thread->getId()}
                {if not empty($pagers.$id)}
                    {$pagers.$id->toString('forum/pager.tpl')}
                {/if}
            </td>
            <td style="padding: 5px; text-align: center;">{$thread->getAuthor()->getUser()->getLogin()}</td>
            <td style="padding: 5px; text-align: center;">{$thread->getPostsCount()}</td>
            <td style="padding: 5px; text-align: center;">{if $thread->getViewCount()}{$thread->getViewCount()}{else}0{/if}</td>
            <td style="padding: 5px; text-align: center;">{$thread->getLastPost()->getAuthor()->getUser()->getLogin()}, <a href="{url route="withId" action="last" id=$thread->getId()}">{$thread->getLastPost()->getPostDate()|date_format:"%e %B %Y / %H:%M:%S"}</a><br />{$thread->getLastPost()->getText()|nl2br}</td>
        </tr>
    {foreachelse}
        <tr>
            <td colspan="5">С момента последнего посещения новых тем не найдено</td>
        </tr>
    {/foreach}
</table>
{if $pager->getPagesTotal() > 1}
    <div class="pages">{$pager->toString()}</div>
{/if}