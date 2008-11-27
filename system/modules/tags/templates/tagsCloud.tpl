{add file="tags.css"}
{foreach from=$tags item=tag}
<a href="{url route=tags tag=$tag->getTag() section=news}" class="tag{$tag->getWeight()}">{$tag->getTag()|h} {*$tag->getCount()}/{$tag->getWeight()*}</a> &nbsp;
{/foreach}