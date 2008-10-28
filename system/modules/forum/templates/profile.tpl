{title append="Форум"}
{title append="Просмотр профиля пользователя"}
<div class="forumContent">
{add file="forum.css"}
<div class="forumTopPanel">
    <div class="left"><a href="{url route="default2" action="forum"}">MZZ Forums</a>
    <img src="{$SITE_PATH}/templates/images/forum/arrow.gif" width="16" height="8" alt="" />
    Профиль {$profile->getUser()->getLogin()}</div>
    <div class="right"><a href="{url route="default2" action="new"}">новые сообщения</a></div>
    <div class="clearRight"></div>
</div>


<table border="0" cellpadding="6" cellspacing="0" class="post">
    <tr>
        <td colspan="2" class="threadHeader">
        <span>
        {if $profile->getAcl('editProfile')}<a href="{url route="withId" action="editProfile" id=$profile->getId()}">Редактировать</a>{/if}
        </span>
        {$profile->getUser()->getLogin()} {$profile->getJip()}
        </td>
    </tr>
    <tr>
        <td class="leftSide forumOddColumn" valign="top">
        Количество сообщений
        </td>
        <td class="rightSide" valign="top">
          {$profile->getMessages()}
        </td>
    </tr>
    {if $profile->getSignature()}
    <tr>
        <td class="leftSide forumOddColumn" valign="top">
        Подпись
        </td>
        <td class="rightSide" valign="top">
          {$profile->getSignature()|htmlspecialchars|nl2br}
        </td>
    </tr>
    {/if}
</table>
</div>