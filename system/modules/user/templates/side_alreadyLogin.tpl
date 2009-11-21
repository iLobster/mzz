<p class="sideBlockTitle">{$user->getLogin()|h}</p>
<div class="sideBlockContent">
<a href="{url route="default2" module="user" action="exit"}/?url={{url appendGet=true}|urlencode}">{_ logout}</a>
</div>
