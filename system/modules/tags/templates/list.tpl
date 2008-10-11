<div class="tagList">
{foreach name=tagsList from=$tags item=tag}
<a href="{url route=tags tag=$tag->getTag() section=$section}">{$tag->getTag()}</a>
{if !$smarty.foreach.tagsList.last}, {/if}
{/foreach}
</div>

<a class="jipLink" href="{url route=withId id=$item_obj_id section=tags action=editTags}">Добавить тэги</a>