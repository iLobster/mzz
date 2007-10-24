{add file="tags.css"}
{foreach from=$tags item=tag}
<a href="{url route=tags tag=$tag->getTag() section=news}" class="tag{$tag->getWeight()}">{$tag->getTag()} {*$tag->getCount()}/{$tag->getWeight()*}</a> &nbsp;
{/foreach}