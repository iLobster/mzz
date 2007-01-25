{foreach from=$comments item=comment}
    {$comment->getAuthor()}, {$comment->getTime()|date_format:"%e %B %Y / %H:%M"}<br />
    {$comment->getText()}
    <hr>
{/foreach}
{$folder->getJip()}
{load module="comments" section="comments" action="post" parent_id=$parent_id}