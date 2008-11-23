<p class="sideBlockTitle">{$user->getLogin()}</p>
<div class="sideBlockContent">

<a href="{url route="withAnyParam" section="message" name="incoming" action="list"}">Личные сообщения</a><br />
<a href="{url route="default2" section="user" action="exit"}/?url={url}">{_ logout}</a>
</div>
