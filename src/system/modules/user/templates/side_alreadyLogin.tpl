<p class="sideBlockTitle">{$user->getLogin()|h}</p>
<div class="sideBlockContent">
<a href="{url route='default2' module='user' action='exit' _url={url appendGet=true encode=true} _csrf}">{_ logout}</a>
</div>
