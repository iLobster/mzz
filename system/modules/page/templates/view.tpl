{title append=$page->getTitle()}
<h2>{$page->getTitle()}{$page->getJip()}</h2>
<p>{if $page->getCompiled()}{assign var="pageId" value=$page->getId()}{include file="page:$pageId"}{else}{$page->getContent()}{/if}</p>

{if $page->getName() ne '403'}
    {if $page->getName() ne '404'}
        {load module="comments" section="comments" action="list" id=$page->getObjId()}
    {/if}
{/if}