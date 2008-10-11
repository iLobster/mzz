{title append=$page->getTitle()}
{meta keywords=$page->getKeywords() reset=$page->isKeywordsReset()}
{meta description=$page->getDescription() reset=$page->isDescriptionReset()}
<h2>{$page->getTitle()}{$page->getJip()}</h2>
<p>{if $page->getCompiled()}{eval var=$page->getContent()}{else}{$page->getContent()}{/if}</p>

{if $page->getName() ne '403'}
    {if $page->getName() ne '404'}
        {if $page->getAllowComment() == 1}
            {load module="ratings" section="ratings" action="view" id=$page->getObjId() owner=2}
            {load module="comments" section="comments" action="list" id=$page->getObjId()}
        {/if}
    {/if}
{/if}