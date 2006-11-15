{foreach from=$comments item=comment}
    {$comment->getAuthor()->getLogin()}, {$comment->getTime()|date_format:"%e %B %Y / %H:%M"}<br />
    {$comment->getText()|htmlspecialchars}
    <hr>
{/foreach}
{load module="comments" section="comments" action="post" parent_id=$news->getObjId()}