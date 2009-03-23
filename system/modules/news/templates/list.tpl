{title append=$newsFolder->getTitle()|htmlspecialchars}
{title append="_ news_list"}
{add file="news.css"}
{include file="news/tree.tpl" rootFolder=$rootFolder newsFolder=$newsFolder}

<div class="newsList">
    {foreach from=$news item=current_news}
      <div class="news_title"><a href="{url route=withId action=view id=$current_news->getId()}">{$current_news->getTitle()|htmlspecialchars}</a>{$current_news->getJip()}</div>

    <div class="news_info">{_ author}: {$current_news->getEditor()->getLogin()}, {$current_news->getCreated()|date_format:"%e %B %Y / %H:%M"},
    {_ edited}: {$current_news->getUpdated()|date_format:"%e %B %Y / %H:%M"}</div>

     <div class="news_text">{$current_news->getAnnotation()|htmlspecialchars}</div>

    {/foreach}

    {if $pager->getPagesTotal() > 0}
        <div class="pages">{$pager->toString()}</div>
    {/if}
</div>

{*
<div style="text-align: center;">
Облако тегов всех объектов <br />
{load module=tags action=tagsCloud tmodule=news tclass=news section=tags}
</div>
*}