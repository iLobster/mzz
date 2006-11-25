<h2>{$page->getTitle()}{$page->getJip()}</h2>
<p>{$page->getContent()}</p>

{if $page->getName() ne '403'}
    {load module="comments" section="comments" action="list" parent_id=$page->getObjId()}
{/if}