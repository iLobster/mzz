<div>
<div id="submenu">
<span class="title">Разделы</span><br />

{foreach from=$newsFolderMapper->getFolders(1) item=current_folder name=folders}
 <a href="{url section=news action=list params=$current_folder->getPath()}">{$current_folder->getName()}</a> {$current_folder->getJip()}
<br />
                            
                        {/foreach}

</div>
</div>



<div class="newsList">
{foreach from=$news item=current_news}
  <div class="news_title"><a href="{url section=news action=view params=$current_news->getId()}">{$current_news->getTitle()}</a>{$current_news->getJip()}</div>

<div class="news_info">Автор: {$current_news->getEditor()->getLogin()}, {$current_news->getCreated()|date_format:"%e %B %Y / %H:%M"}, 
Редактировано: {$current_news->getUpdated()|date_format:"%e %B %Y / %H:%M"}</div>


 <div class="news_text">{$current_news->getText()}</div>


{/foreach}



<a href="{url section=news action=createItem params=$folderPath}"><img src="/templates/images/add.gif" width="16" height="16" border="0" /></a>
<a href="{url section=news action=createItem params=$folderPath}">Добавить новость</a>
<div class="pages">Страницы: {$pager->toString()}</div>
</div>
