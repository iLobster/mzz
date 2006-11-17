{foreach from=$comments item=comment}
    {$comment->getAuthor()->getLogin()}, {$comment->getTime()|date_format:"%e %B %Y / %H:%M"} {$comment->getJip()}<br />
    {$comment->getText()|htmlspecialchars}
    <hr>
{/foreach}
{$folder->getJip()}
{load module="comments" section="comments" action="post" parent_id=$parent_id 403handle="manual" 403tpl="comments.blank.tpl"}