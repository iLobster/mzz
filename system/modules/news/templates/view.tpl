{title append=$news->getTitle()}
{title append="�������"}
{add file="news.css"}
{include file="news/tree.tpl" source=$news->getFolder()}
<div class="newsList">

<div class="news_title">{$news->getTitle()|htmlspecialchars}{$news->getJip()}</div>

<div class="news_info">�����: {$news->getEditor()->getLogin()}, {$news->getCreated()|date_format:"%e %B %Y / %H:%M"},
�������������: {$news->getUpdated()|date_format:"%e %B %Y / %H:%M"}</div>

<div class="news_text">{$news->getText()|htmlspecialchars}</div>
{load module="tags" section="tags" action="list" parent_id=$news->getObjId()}
{load module="comments" section="comments" action="list" id=$news->getObjId() owner=$news->getEditor()->getId()}

</div>