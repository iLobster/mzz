{title append="Форум"}
{title append=$thread->getForum()->getTitle()}
{title append=$thread->getTitle()}
{add file="forum.css"}
<div class="forumContent">
<div class="forumTopPanel">
    <div class="left"><a href="{url route="default2" action="forum"}">MZZ Forums</a>
    <img src="{$SITE_PATH}/templates/images/forum/arrow.gif" width="16" height="8" alt="" />
    <a href="{url route="withId" action="list" id=$thread->getForum()->getId()}">{$thread->getForum()->getTitle()}</a>
    <img src="{$SITE_PATH}/templates/images/forum/arrow.gif" width="16" height="8" alt="" /> {$thread->getTitle()}</div>
    <div class="right">{include file="forum/forumMenu.tpl"}</div>
    <div class="clearRight"></div>
</div>

<div class="forumThreadPanel">
    <div class="right">
        {if $thread->getAcl('editThread')}
            <a href="{url route="withId" action="editThread" id=$thread->getId()}">Редактировать</a>
        {/if}
        {if $thread->getAcl('moveThread')}
            - <a href="{url route="withId" action="moveThread" id=$thread->getId()}">Перенести</a>
        {/if}
        {if $thread->getACL('post')}
            - <a href="{url route="withId" action="post" id=$thread->getId()}">Ответить</a>
        {/if}
    </div>
    <div class="clearRight"></div>
</div>


<table border="0" cellpadding="6" cellspacing="0" class="thread">
    <tr>
        <td colspan="2" class="threadHeader">
        {$thread->getTitle()}
        </td>
    </tr>
{assign post_number=1}
{foreach from=$posts item="post" name="post_cycle"}
    <tr>
        <td class="authorInfo" valign="top" rowspan="2">
            <a href="{url route="withId" action="profile" id=$post->getAuthor()->getId()}" class="authorName">{$post->getAuthor()->getUser()->getLogin()}</a>
            {if $post->getAuthor()->getAvatar()}<br /><br /><img class="forumAvatar" src="{$SITE_PATH}{$post->getAuthor()->getAvatar()->getDownloadLink()}" alt="{$post->getAuthor()->getUser()->getLogin()} avatar" /><br />{/if}
            <p class="forumDescription">Сообщений: {$post->getAuthor()->getMessages()}
            {if $post->getAuthor()->getLocation()}<br />Откуда: {$post->getAuthor()->getLocation()}{/if}</p>
        </td>
        <td class="postInfo forumOddColumn">
        <div class="postLink">
        {if !$thread->getIsStickyFirst() || $pager->getRealPage() == 1 || !$smarty.foreach.post_cycle.first}
            {math equation="(page - 1)* per_page + number" page=$pager->getRealPage() per_page=$pager->getPerPage() number=$post_number assign=post_number}
        {/if}
        <a href="{url route="withId" id=$post->getId() action="goto"}">#{$post_number}</a></div>
        {if $thread->getIsStickyFirst() && $pager->getRealPage() != 1}
            {assign post_number=$smarty.foreach.post_cycle.iteration}
        {else}
            {assign post_number=$post_number+1}
        {/if}
        <div class="postIcon">
        <a name="post_{$post->getId()}"></a><img src="{$SITE_PATH}/templates/images/forum/posticon.gif" alt="" width="9" height="10" /> </div>
        {$post->getPostDate()|date_format:"%e %B %Y / %H:%M:%S"}
        </td>
    </tr>

    <tr>
        <td class="postContent" valign="top">
            {$post->getText()|escape:html_utf|bbcode|nl2br}
            {if $post->getEditDate()}
                <div class="postEditDate">отредактировано {$post->getEditDate()|date_format:"%e %B %Y / %H:%M:%S"}</div>
            {/if}
            {if $post->getAuthor()->getSignature()}
            <div class="forumPostSign">_____________________</div>
            {$post->getAuthor()->getSignature()|htmlspecialchars|nl2br}
            {/if}
        </td>
    </tr>

    <tr>
        <td class="postActionsLeft authorInfo" valign="top"><span class="forumButton"><a href="#">Report</a></span></td>
        <td valign="top" class="postActions">
        <div>
        {if $thread->getFirstPost()->getId() ne $post->getId() && $post->getAcl('edit')}
            <span class="forumButton"><a href="#">Удалить</a></span>
            <span class="forumButton"><a href="{url route="withId" action="edit" id=$post->getId()}">Изменить</a></span>
        {/if}
        {if $thread->getACL('post')}
            <span class="forumButton"><a href="{url route="withId" action="post" id=$thread->getId()}">Ответить</a></span>
        {/if}
        </div>
        </td>
    </tr>

{/foreach}
</table>
<br />
{if $pager->getPagesTotal() > 1}
    <div class="pages">{$pager->toString()}</div><br />
{/if}
{load module="forum" action="post" id=$thread->getId() quickpost="true"}
</div>