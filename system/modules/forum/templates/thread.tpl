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
    <div class="right"><a href="{url route="default2" action="new"}">новые сообщения</a></div>
    <div class="clearRight"></div>
</div>

{set name="threadHeaderTpl"}
  <tr>
        <td colspan="2" class="threadHeader">
        {$thread->getTitle()}
        </td>
    </tr>
{/set}

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

{if $thread->getIsStickyFirst() && $pager->getRealPage() != 1}
{assign var="post" value=$thread->getFirstPost()}
<table border="0" cellpadding="6" cellspacing="0" class="thread">
    {$threadHeaderTpl}
    <tr>
        <td class="authorInfo forumOddColumn" valign="top" rowspan="2">
            <strong><a href="{url route="withId" action="profile" id=$post->getAuthor()->getId()}">{$post->getAuthor()->getUser()->getLogin()}</a></strong>
            {if $post->getAuthor()->getAvatar()}<br /><br /><img src="{$post->getAuthor()->getAvatar()->getDownloadLink()}" alt="{$post->getAuthor()->getUser()->getLogin()} avatar" /><br />{/if}
            <p class="forumDescription">Сообщений: {$post->getAuthor()->getMessages()}</p>
        </td>
        <td class="postInfo forumOddColumn">
        <div class="postLink">
        <a href="{url route="withId" id=$post->getId() action="goto"}">#1</a></div>
        <div class="postIcon">
        <a name="post_{$post->getId()}"></a><img src="{$SITE_PATH}/templates/images/forum/posticon.gif" alt="" width="9" height="10" /> </div>
        {$post->getPostDate()|date_format:"%e %B %Y / %H:%M:%S"}
        </td>
    </tr>

    <tr>
        <td class="postContent" valign="top">
            {$post->getText()|htmlspecialchars|nl2br|bbcode}
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
        <td class="postActionsLeft forumOddColumn" valign="top"><img src="{$SITE_PATH}/templates/images/forum/report.gif" alt="" /></td>
        <td valign="top" class="postActions">
        <div>
        {if $thread->getFirstPost()->getId() ne $post->getId() && $post->getAcl('edit')}
        <img src="{$SITE_PATH}/templates/images/forum/delete.gif" alt="" />
        <a href="{url route="withId" action="edit" id=$post->getId()}"><img src="{$SITE_PATH}/templates/images/forum/edit.gif" alt="" /></a>
        {/if}
        {if $thread->getACL('post')}
            <a href="{url route="withId" action="post" id=$thread->getId()}"><img src="{$SITE_PATH}/templates/images/forum/reply.gif" alt="" /></a>
        {/if}
        </div>
        </td>
    </tr>
</table>
{/if}


{foreach from=$posts item="post" name="post_cycle"}
<table border="0" cellpadding="6" cellspacing="0" class="thread">
    {if $thread->getFirstPost()->getId() eq $post->getId() && (!$thread->getIsStickyFirst() || $pager->getRealPage() == 1)}
        {$threadHeaderTpl}
    {/if}
    <tr>
        <td class="authorInfo forumOddColumn" valign="top" rowspan="2">
            <strong><a href="{url route="withId" action="profile" id=$post->getAuthor()->getId()}">{$post->getAuthor()->getUser()->getLogin()}</a></strong>
            {if $post->getAuthor()->getAvatar()}<br /><br /><img src="{$SITE_PATH}{$post->getAuthor()->getAvatar()->getDownloadLink()}" alt="{$post->getAuthor()->getUser()->getLogin()} avatar" /><br />{/if}
            <p class="forumDescription">Сообщений: {$post->getAuthor()->getMessages()}</p>
        </td>
        <td class="postInfo forumOddColumn">
        <div class="postLink">{math equation="(page - 1)* per_page + number" page=$pager->getRealPage() per_page=$pager->getPerPage() number=$smarty.foreach.post_cycle.iteration assign=post_number}
        <a href="{url route="withId" id=$post->getId() action="goto"}">#{$post_number}</a></div>
        <div class="postIcon">
        <a name="post_{$post->getId()}"></a><img src="{$SITE_PATH}/templates/images/forum/posticon.gif" alt="" width="9" height="10" /> </div>
        {$post->getPostDate()|date_format:"%e %B %Y / %H:%M:%S"}
        </td>
    </tr>

    <tr>
        <td class="postContent" valign="top">
            {$post->getText()|htmlspecialchars|nl2br|bbcode}
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
        <td class="postActionsLeft forumOddColumn" valign="top"><img src="{$SITE_PATH}/templates/images/forum/report.gif" alt="" /></td>
        <td valign="top" class="postActions">
        <div>
        {if $thread->getFirstPost()->getId() ne $post->getId() && $post->getAcl('edit')}
        <img src="{$SITE_PATH}/templates/images/forum/delete.gif" alt="" />
        <a href="{url route="withId" action="edit" id=$post->getId()}"><img src="{$SITE_PATH}/templates/images/forum/edit.gif" alt="" /></a>
        {/if}
        {if $thread->getACL('post')}
            <a href="{url route="withId" action="post" id=$thread->getId()}"><img src="{$SITE_PATH}/templates/images/forum/reply.gif" alt="" /></a>
        {/if}
        </div>
        </td>
    </tr>
</table>

{/foreach}
<br />
{if $pager->getPagesTotal() > 1}
    <div class="pages">{$pager->toString()}</div><br />
{/if}
{load module="forum" action="post" id=$thread->getId() quickpost="true"}
</div>