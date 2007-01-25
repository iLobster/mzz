{add file="news.css"}
{include file="news/tree.tpl" source=$newsFolder}

<div class="newsList">
{foreach from=$news item=current_news}
  <div class="news_title"><a href="{url section=news action=view params=$current_news->getId()}">{$current_news->getTitle()}</a>{$current_news->getJip()}</div>

<div class="news_info">Автор: {$current_news->getEditor()->getLogin()}, {$current_news->getCreated()|date_format:"%e %B %Y / %H:%M"},
Редактировано: {$current_news->getUpdated()|date_format:"%e %B %Y / %H:%M"}</div>


 <div class="news_text">{$current_news->getText()}</div>


{/foreach}


<a href="{url section=news action=create params=$folderPath}" onclick="javascript: return showJip(this.href);"><img src="{$SITE_PATH}/templates/images/add.gif" width="16" height="16" alt="Добавить новость" /></a>
<a href="{url section=news action=create params=$folderPath}" onclick="javascript: return showJip(this.href);">Добавить новость</a>
<div class="pages">{$pager->toString()}</div>
</div>


