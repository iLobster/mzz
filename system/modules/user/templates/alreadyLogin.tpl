<h1>{$user->getLogin()|h}</h1>
<div>
<a href="{url route="default2" module="user" action="exit"}/?url={{url appendGet=true}|urlencode}">{_ logout}</a>
</div>
