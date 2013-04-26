{title append=$page->getTitle()}
{meta keywords=$page->getKeywords() reset=$page->isKeywordsReset()}
{meta description=$page->getDescription() reset=$page->isDescriptionReset()}
<h2>{$page->getTitle()}{$page->getJip()}</h2>
<p>{if $page->getCompiled()}{eval var=$page->getContent()}{else}{$page->getContent()}{/if}</p>

{if $page->getAllowComment()}
{load module="comments" action="list" object=$page}
{/if}