{title append="Форум"}
{title append="Просмотр профиля пользователя"}

<a href="{url route="default2" action="forum"}">Форум</a> / Просмотр профиля пользователя {$profile->getJip()} <strong>{$profile->getUser()->getLogin()}{if $profile->getAcl('editProfile')} (<a href="{url route="withId" action="editProfile" id=$profile->getId()}">Редактировать</a>){/if}</strong>
<br /><br />
Количество сообщений: {$profile->getMessages()}<br />
Подпись: {if $profile->getSignature()}{$profile->getSignature()|htmlspecialchars|nl2br}{else}—{/if}