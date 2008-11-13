{title append="Форум"}
{title append="Просмотр профиля пользователя"}
<div class="forumContent">
{add file="forum.css"}
<div class="forumTopPanel">
    <div class="left"><a href="{url route="default2" action="forum"}">MZZ Forums</a>
    <img src="{$SITE_PATH}/templates/images/forum/arrow.gif" width="16" height="8" alt="" />
    Профиль {$profile->getUser()->getLogin()}</div>
    <div class="right">{include file="forum/forumMenu.tpl"}</div>
    <div class="clearRight"></div>
</div>


<table border="0" cellpadding="6" cellspacing="0" class="post">
    <tr>
        <td class="threadHeader">
        <span>
        {if $profile->getAcl('editProfile')}<a href="{url route="withId" action="editProfile" id=$profile->getId()}">Редактировать</a>{/if}
        </span>

        {$profile->getUser()->getLogin()} {$profile->getJip()}
        </td>
    </tr>
    <tr>
        <td class="leftSide forumOddColumn" valign="top">
        {if $profile->getAvatar()}<div class="userProfileAvatar">
        <img class="forumAvatar" src="{$SITE_PATH}{$profile->getAvatar()->getDownloadLink()}" alt="{$profile->getUser()->getLogin()} avatar" />
        </div>{/if}
        <div class="userProfileInfo">
            <span class="userProfileUserName">{$profile->getUser()->getLogin()}</span><br />
            Сообщений: <span class="userProfileText">{$profile->getMessages()}</span><br />
            Дата регистрации: <span class="userProfileText">{$profile->getUser()->getCreated()|date_format:"%d.%m.%Y"}</span><br />
        </div>
        <div class="clear"></div>
        <div class="userProfileFullInfo">
        {if $profile->getSignature()}
            Подпись: <span class="userProfileText">{$profile->getSignature()|htmlspecialchars|nl2br}</span><br />
        {/if}
        {if $profile->getBirthday()}
            Дата рождения: <span class="userProfileText">{$profile->getBirthday()}</span><br />
        {/if}
        {if $profile->getIcq()}
            ICQ: <span class="userProfileText">{$profile->getIcq()}</span><br />
        {/if}
        {if $profile->getLocation()}
            Город: <span class="userProfileText">{$profile->getLocation()|htmlspecialchars}</span><br />
        {/if}
        {if $profile->getUrl()}
            URL: <span class="userProfileText">{$profile->getUrl()|htmlspecialchars}</span><br />
        {/if}
        </div>
        </td>
    </tr>
</table>
</div>