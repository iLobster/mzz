{include file="news/news.tree.tpl" source=$newsFolder}

<div class="newsList">
{foreach from=$news item=current_news}
  <div class="news_title"><a href="{url section=news action=view params=$current_news->getId()}">{$current_news->getTitle()}</a>{$current_news->getJip()}</div>

<div class="news_info">�����: {$current_news->getEditor()->getLogin()}, {$current_news->getCreated()|date_format:"%e %B %Y / %H:%M"},
�������������: {$current_news->getUpdated()|date_format:"%e %B %Y / %H:%M"}</div>


 <div class="news_text">{$current_news->getText()}</div>


{/foreach}


<a href="{url section=news action=createItem params=$folderPath}" onclick="javascript: return showJip('{url section=news action=createItem params=$folderPath}');"><img src="{url section="templates" params="images/add.gif"}" width="16" height="16" alt="�������� �������" /></a>
<a href="{url section=news action=createItem params=$folderPath}" onclick="javascript: return showJip('{url section=news action=createItem params=$folderPath}');">�������� �������</a>
<div class="pages">{$pager->toString()}</div>
</div>


