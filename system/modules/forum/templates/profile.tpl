{title append="Форум"}
{title append="Просмотр профиля пользователя"}

<a href="{url route="default2" action="forum"}">Форум</a> / Просмотр профиля пользователя <strong>{$profile->getUser()->getLogin()}</strong>
<br /><br />
Количество сообщений: {$profile->getMessages()}<br />
Подпись: {if $profile->getSignature()}{$profile->getSignature()|htmlspecialchars|nl2br}{else}—{/if}