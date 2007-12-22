{title append=$newsFolder->getTitle()|htmlspecialchars}
{title append="Список новостей"}
{add file="news.css"}
{include file="news/tree.tpl" source=$newsFolder}

<div class="newsList">
    {foreach from=$news item=current_news}
      <div class="news_title"><a href="{url route=withId action=view id=$current_news->getId()}">{$current_news->getTitle()|htmlspecialchars}</a>{$current_news->getJip()}</div>

    <div class="news_info">Автор: {$current_news->getEditor()->getLogin()}, {$current_news->getCreated()|date_format:"%e %B %Y / %H:%M"},
    Редактировано: {$current_news->getUpdated()|date_format:"%e %B %Y / %H:%M"}</div>

     <div class="news_text">{$current_news->getAnnotation()|htmlspecialchars}</div>

    {/foreach}
    {if $pager->getPagesTotal() > 0}
        <div class="pages">{$pager->toString()}</div>
    {/if}
</div>


<div align="center">
Облако тегов всех объектов <br />
{load module=tags action=tagsCloud tmodule=news tclass=news section=tags}
</div>

{_ MESS}