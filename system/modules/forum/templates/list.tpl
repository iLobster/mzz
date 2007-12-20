<a href="{url route=default2 action=forum}">Форум</a> / {$forum->getTitle()}
{if $forum->getAcl('newThread')} (<a href="{url route=withId action=newThread id=$forum->getId()}">Начать новую тему</a>){/if}<br />
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr style="background-color: #EFF2F5;">
        <td style="padding: 5px; text-align: center; border-bottom: 1px solid #DEE4EB;">&nbsp;</td>
        <td style="width: 54%; padding: 5px; border-bottom: 1px solid #DEE4EB;">Название</td>
        <td style="padding: 5px; text-align: center; border-bottom: 1px solid #DEE4EB;">Автор</td>
        <td style="padding: 5px; text-align: center; border-bottom: 1px solid #DEE4EB;">Постов</td>
        <td style="padding: 5px; text-align: center; border-bottom: 1px solid #DEE4EB;">Просмотров</td>
        <td style="padding: 5px; text-align: center; border-bottom: 1px solid #DEE4EB;">Последнее сообщение</td>
    </tr>
    {foreach from=$stickys item="thread"}
        <tr bgcolor="#FFF000">
            <td>Важно!!!</td>
            <td style="padding: 5px;">
                <a href="{url route=withId action=thread id=$thread->getId()}">{$thread->getTitle()}</a>
                {assign var=id value=$thread->getId()}
                {if not empty($pagers.$id)}
                    {$pagers.$id->toString('forum/pager.tpl')}
                {/if}
            </td>
            <td style="padding: 5px; text-align: center;">{$thread->getAuthor()->getLogin()}</td>
            <td style="padding: 5px; text-align: center;">{$thread->getPostsCount()}</td>
            <td style="padding: 5px; text-align: center;">{if $thread->getViewCount()}{$thread->getViewCount()}{else}0{/if}</td>
            <td>{$thread->getLastPost()->getAuthor()->getLogin()}, <a href="{url route=withId action=last id=$thread->getId()}">{$thread->getLastPost()->getPostDate()|date_format:"%e %B %Y / %H:%M:%S"}</a></td>
        </tr>
    {/foreach}
    {foreach from=$threads item="thread"}
        <tr>
            <td>
                {if $thread->isNew()}
                    <span style="color: red;">new!!!</span>
                {else}
                    &nbsp;
                {/if}
                {if $thread->isPopular()}
                    <span style="color: blue;">popular!!!</span>
                {else}
                    &nbsp;
                {/if}
            </td>
            <td style="padding: 5px;">
                <a href="{url route=withId action=thread id=$thread->getId()}">{$thread->getTitle()}</a>
                {assign var=id value=$thread->getId()}
                {if not empty($pagers.$id)}
                    {$pagers.$id->toString('forum/pager.tpl')}
                {/if}
            </td>
            <td style="padding: 5px; text-align: center;">{$thread->getAuthor()->getLogin()}</td>
            <td style="padding: 5px; text-align: center;">{$thread->getPostsCount()}</td>
            <td style="padding: 5px; text-align: center;">{if $thread->getViewCount()}{$thread->getViewCount()}{else}0{/if}</td>
            <td>{$thread->getLastPost()->getAuthor()->getLogin()}, <a href="{url route=withId action=last id=$thread->getId()}">{$thread->getLastPost()->getPostDate()|date_format:"%e %B %Y / %H:%M:%S"}</a></td>
        </tr>
    {/foreach}
</table>
<br />
{if $pager->getPagesTotal() > 1}
    <div class="pages">{$pager->toString()}</div>
{/if}