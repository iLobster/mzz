<p class="sideBlockTitle">{$user->getLogin()|h}</p>
<div class="sideBlockContent">
{set name="url}{url appendGet=true}{/set}
<a href="{url route="default2" module="user" action="exit"}/?url={$url|urlencode}">{_ logout}</a>
</div>
