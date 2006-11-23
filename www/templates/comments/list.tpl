{add file='comment.css'}
<div class="commentsTitle">Комментарии ({$comments|@count}) {$folder->getJip()}</div>
{foreach from=$comments item=comment}
<div class="commentTitle">{$comment->getAuthor()->getLogin()} {$comment->getTime()|date_format:"%e %B %Y / %H:%M"} {$comment->getJip()}</div>
<div class="commentText">{$comment->getText()|htmlspecialchars|nl2br}</div>
{/foreach}
<br />
{load module="comments" section="comments" action="post" parent_id=$parent_id 403handle="manual" 403tpl="comments/deny.tpl"} {* 403level="global" *}