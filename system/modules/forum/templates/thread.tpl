<a href="{url route=default2 action=forum}">Форум</a> / <a href="{url route=withId action=list id=$thread->getForum()->getId()}">{$thread->getForum()->getTitle()}</a> / {$thread->getTitle()}
{if $thread->getACL('post')} (<a href="{url route=withId action=post id=$thread->getId()}">Ответить</a>){/if}<br /><br />

{foreach from=$posts item=post name=post_cycle}
    <table border="1" width="100%">
        <tr>
            <td>
                <a name="post_{$post->getId()}"></a>{$post->getAuthor()->getLogin()}, {$post->getPostDate()|date_format:"%e %B %Y / %H:%M:%S"}{if $post->getEditDate()}, отредактировано {$post->getEditDate()|date_format:"%e %B %Y / %H:%M:%S"}{/if}
                {if $thread->getFirstPost()->getId() eq $post->getId()}
                    {if $thread->getAcl('editThread')}
                        <a href="{url route=withId action=editThread id=$thread->getId()}">Редактировать</a>
                    {/if}
                    {if $thread->getAcl('moveThread')}
                        <a href="{url route=withId action=moveThread id=$thread->getId()}">Перенести</a>
                    {/if}
                {else}
                    {if $post->getAcl('edit')} <a href="{url route=withId action=edit id=$post->getId()}">Редактировать</a>{/if}
                {/if}
            </td>
            <td align="right">
                {math equation="(page - 1)* per_page + number" page=$pager->getRealPage() per_page=$pager->getPerPage() number=$smarty.foreach.post_cycle.iteration assign=post_number}
                <a href="{url route=withId id=$post->getId() action=goto}">#{$post_number}</a>
            </td>
        </tr>
        <tr>
            <td colspan="2">{$post->getText()|htmlspecialchars|nl2br}</td>
        </tr>
    </table>
    <br />
{/foreach}


{if $pager->getPagesTotal() > 0}
    <div class="pages">{$pager->toString()}</div>
{/if}

{load module="forum" action="post" id=$thread->getId() 403handle="manual"}