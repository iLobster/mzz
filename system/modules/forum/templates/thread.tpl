{title append="Форум"}
{title append=$thread->getForum()->getTitle()}
{title append=$thread->getTitle()}

<a href="{url route="default2" action="forum"}">Форум</a> / <a href="{url route="withId" action="list" id=$thread->getForum()->getId()}">{$thread->getForum()->getTitle()}</a> / {$thread->getTitle()}
{if $thread->getACL('post')} (<a href="{url route="withId" action="post" id=$thread->getId()}">Ответить</a>){/if}<br /><br />

{if $thread->getIsStickyFirst() && $pager->getRealPage() != 1}
{assign var="post" value=$thread->getFirstPost()}
<table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr style="background-color: #EFF2F5;">
            <td style="width: 7%; padding: 5px; border-bottom: 1px solid #DEE4EB;">
                <a name="post_{$post->getId()}"></a>{$post->getAuthor()->getLogin()}, {$post->getPostDate()|date_format:"%e %B %Y / %H:%M:%S"}{if $post->getEditDate()}, отредактировано {$post->getEditDate()|date_format:"%e %B %Y / %H:%M:%S"}{/if}
                {if $thread->getFirstPost()->getId() eq $post->getId()}
                    {if $thread->getAcl('editThread')}
                        <a href="{url route="withId" action="editThread" id=$thread->getId()}">Редактировать</a>
                    {/if}
                    {if $thread->getAcl('moveThread')}
                        <a href="{url route="withId" action="moveThread" id=$thread->getId()}">Перенести</a>
                    {/if}
                {else}
                    {if $post->getAcl('edit')} <a href="{url route="withId" action="edit" id=$post->getId()}">Редактировать</a>{/if}
                {/if}
            </td>
            <td style="width: 7%; padding: 5px; border-bottom: 1px solid #DEE4EB;" align="right">
                <a href="{url route="withId" id=$post->getId() action="goto"}">#1</a>
            </td>
        </tr>
        <tr>
            <td style="border: 1px solid #DEE4EB; padding: 10px 10px 10px 10px" colspan="2">{$post->getText()|htmlspecialchars|nl2br}</td>
        </tr>
    </table>
    <br />
    <hr />
    <br />
{/if}

{foreach from=$posts item="post" name="post_cycle"}
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr style="background-color: #EFF2F5;">
            <td style="width: 7%; padding: 5px; border-bottom: 1px solid #DEE4EB;">
                <a name="post_{$post->getId()}"></a>{$post->getAuthor()->getLogin()}, {$post->getPostDate()|date_format:"%e %B %Y / %H:%M:%S"}{if $post->getEditDate()}, отредактировано {$post->getEditDate()|date_format:"%e %B %Y / %H:%M:%S"}{/if}
                {if $thread->getFirstPost()->getId() eq $post->getId()}
                    {if $thread->getAcl('editThread')}
                        <a href="{url route="withId" action="editThread" id=$thread->getId()}">Редактировать</a>
                    {/if}
                    {if $thread->getAcl('moveThread')}
                        <a href="{url route="withId" action="moveThread" id=$thread->getId()}">Перенести</a>
                    {/if}
                {else}
                    {if $post->getAcl('edit')} <a href="{url route="withId" action="edit" id=$post->getId()}">Редактировать</a>{/if}
                {/if}
            </td>
            <td style="width: 7%; padding: 5px; border-bottom: 1px solid #DEE4EB;" align="right">
                {math equation="(page - 1)* per_page + number" page=$pager->getRealPage() per_page=$pager->getPerPage() number=$smarty.foreach.post_cycle.iteration assign=post_number}
                <a href="{url route="withId" id=$post->getId() action="goto"}">#{$post_number}</a>
            </td>
        </tr>
        <tr>
            <td style="border: 1px solid #DEE4EB; padding: 10px 10px 10px 10px" colspan="2">{$post->getText()|htmlspecialchars|nl2br}</td>
        </tr>
    </table>
    <br />
{/foreach}


{if $pager->getPagesTotal() > 1}
    <div class="pages">{$pager->toString()}</div>
{/if}
<br /><br />
{load module="forum" action="post" id=$thread->getId() 403handle="manual" quickpost="true"}