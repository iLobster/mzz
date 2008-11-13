{title append="Форум"}
{title append=$thread->getForum()->getTitle()}
{title append=$thread->getTitle()}
{add file="forum.css"}
<div class="forumContent">
<div class="forumTopPanel">
    <div class="left">
        <a href="{url route="default2" action="forum"}">MZZ Forums</a>
        <img src="{$SITE_PATH}/templates/images/forum/arrow.gif" width="16" height="8" alt="" />
        <a href="{url route="withId" action="list" id=$thread->getForum()->getId()}">{$thread->getForum()->getTitle()}</a>
        <img src="{$SITE_PATH}/templates/images/forum/arrow.gif" width="16" height="8" alt="" />
        <a href="{url route="withId" action="thread" id=$thread->getId()}">{$thread->getTitle()}</a>
        <img src="{$SITE_PATH}/templates/images/forum/arrow.gif" width="16" height="8" alt="" />
        {if $isEdit}
            {title append="Редактирование поста"}
            Редактирование поста
        {else}
            {title append="Создание нового поста"}
            Создание нового поста
        {/if}
    </div>
    <div class="right">{include file="forum/forumMenu.tpl"}</div>
    <div class="clearRight"></div>
</div>


{form action=$action method="post"}
<table border="0" cellpadding="6" cellspacing="0" class="post">
    <tr>
        <td colspan="2" class="threadHeader">Ответить</td>
    </tr>
    <tr>
        <td class="leftSide forumOddColumn" valign="top">
        {form->caption name="text" value="Текст сообщения" onError="style=color: red;"}
        </td>
        <td class="rightSide" valign="top">
          {form->textarea name="text" rows="20" cols="55" style="width: 98%;" value=$post->getText()}<br />
          {$errors->get('text')}
        </td>
    </tr>
    <tr>
        <td class="postInfo forumOddColumn" valign="top">

        &nbsp;
        </td>
        <td class="rightSide" valign="top">
          {form->submit name="submit" value="Отправить"} {form->reset name="reset" value="Отмена"}
        </td>
    </tr>
</table>

</form>

{if !$isEdit}
<br />
{foreach from=$posts item="ppost" name="lastPosts"}
<table border="0" cellpadding="6" cellspacing="0" class="thread">
    {if $smarty.foreach.lastPosts.first}
    <tr>
        <td colspan="2" class="threadHeader">Обзор темы (новые сверху)</td>
    </tr>
    {/if}
    <tr>
        <td class="authorInfo forumOddColumn" valign="top" rowspan="2">
            <strong><a href="{url route="withId" action="profile" id=$ppost->getAuthor()->getId()}">{$ppost->getAuthor()->getUser()->getLogin()}</a></strong>
            {if $ppost->getAuthor()->getAvatar()}<br /><br /><img src="{$ppost->getAuthor()->getAvatar()->getDownloadLink()}" alt="{$ppost->getAuthor()->getUser()->getLogin()} avatar" /><br />{/if}
            <p class="forumDescription">Сообщений: {$ppost->getAuthor()->getMessages()}</p>
        </td>
        <td class="postInfo forumOddColumn">
        <div class="postIcon">
        <a name="post_{$ppost->getId()}"></a><img src="{$SITE_PATH}/templates/images/forum/posticon.gif" alt="" width="9" height="10" /> </div>
        {$ppost->getPostDate()|date_format:"%e %B %Y / %H:%M:%S"}
        </td>
    </tr>

    <tr>
        <td class="postContent" valign="top">
            {$ppost->getText()|htmlspecialchars|nl2br|bbcode}
            {if $ppost->getEditDate()}
                <div class="postEditDate">отредактировано {$ppost->getEditDate()|date_format:"%e %B %Y / %H:%M:%S"}</div>
            {/if}
            {if $ppost->getAuthor()->getSignature()}
            <div class="forumPostSign">_____________________</div>
            {$ppost->getAuthor()->getSignature()|htmlspecialchars|nl2br}
            {/if}
        </td>
    </tr>

    <tr>
        <td class="postActionsLeft forumOddColumn" valign="top">&nbsp;</td>
        <td valign="top" class="postActions">&nbsp;</td>
    </tr>
</table>
{/foreach}
{/if}
</div>