<h1>{$user->getLogin()|h}</h1>
<div>
<a href="{url route='default2' module='user' action='exit' _url={url appendGet=true encode=true} _csrf}">{_ logout}</a>
</div>
