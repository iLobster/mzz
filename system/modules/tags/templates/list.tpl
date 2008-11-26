<div class="tagList">
{foreach name=tagsList from=$tags item=tag}
<a href="{url route=tags tag=$tag->getTag() section=$section}">{$tag->getTag()}</a>
{if !$smarty.foreach.tagsList.last}, {/if}
{/foreach}
</div>