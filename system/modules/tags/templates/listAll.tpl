<ul>
{foreach name=tagsList from=$tags item=tag}
    <li>{$tag->getTag()|htmlspecialchars}</li>
{/foreach}
</ul>