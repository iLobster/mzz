{title append=$news->getTitle()}
{title append="_ news"}
{add file="news.css"}
<div class="newsList">

    <div class="news_title">{$news->getTitle()|htmlspecialchars}{$news->getJip()}</div>

    <div class="news_info">{_ author}: {$news->getEditor()->getLogin()}, {$news->getCreated()|date_format:"%e %B %Y / %H:%M"},
    {_ edited}: {$news->getUpdated()|date_format:"%e %B %Y / %H:%M"}</div>

    <div class="news_text">{$news->getText()|htmlspecialchars}</div>
</div>