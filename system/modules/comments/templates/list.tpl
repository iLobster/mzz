{add file="comments.css"}
{if !$comments->isEmpty()}
    {assign var="count" value=$comments|@count}
    <div class="commentsTitle">{_ comments_count $count} {$commentFolder->getJip()}</div>
    {foreach from=$comments item=comment}
        <div style="padding-left: {math equation="level * offset - offset" level=$comment->getTreeLevel() offset=30}px;">
            <div class="commentAuthor">{$comment->getUser()->getLogin()} <span class="commentDate">({$comment->getCreated()|date_format:"%e %b %Y, %H:%M"})</span> {$comment->getJip()}</div>
            <div class="commentText">
                {$comment->getText()|htmlspecialchars|nl2br}
                {load module="comments" action="post" id=$commentFolder replyTo=$comment->getId()}
                {*<br />
                <a href="{url route="withId" action="post" id=$commentFolder->getId()}?replyTo={$comment->getId()}">ответить</a>*}
            </div>
        </div>
    {/foreach}
{else}
    <div class="emptyComments">
        {_ no_comments}
    </div>
{/if}
<br />
{load module="comments" action="post" id=$commentFolder}