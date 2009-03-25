<p class="sideBlockTitle">{$user->getLogin()}</p>
<div class="sideBlockContent">
{set name="url}{url appendGet=true}{/set}
<a href="{url route="default2" section="user" action="exit"}/?url={$url|urlencode}">{_ logout}</a>
</div>
