{foreach from=$categories item="category"}
<a href="{url route="withAnyParam" section="faq" action="list" name=$category->getName()}">{if $current == $category->getName()}<strong>{/if}{$category->getTitle()}{if $current == $category->getName()}</strong>{/if}</a>{$category->getJip()}<br />
{/foreach}