{title append=$news->getTitle()}
{title append="_ news"}
{add file="news.css"}
<div class="newsList">

    <div class="news_title">{$news->getTitle()|h}{$news->getJip()}</div>

    <div class="news_info">{_ author}: {$news->getEditor()->getLogin()}, {$news->getCreated()|date_i18n},
    {_ edited}: {$news->getUpdated()|date_i18n}</div>

    <div class="news_text">{$news->getText()|h}</div>
</div>

{load module="comments" action="list" object=$news}