{add file='comment.css'}
{if !empty($comments)}
    {assign var="count" value=$comments|@count}
    <div class="commentsTitle">{_ comments_count $count} {$folder->getJip()}</div>
    {foreach from=$comments item=comment}
        <div class="commentAuthor">{$comment->getAuthor()->getLogin()} <span class="commentDate">({$comment->getTime()|date_format:"%e %b %Y, %H:%M"})</span> {$comment->getJip()}</div>
        <div class="commentText">{$comment->getText()|htmlspecialchars|nl2br}</div>
    {/foreach}
{else}
    <div class="emptyComments">
        {_ no_comments}
    </div>
{/if}
<br />
{load module="comments" section="comments" action="post" parent_id=$parent_id 403handle="manual"}