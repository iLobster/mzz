{add file="comments.css"}
{add file="prototype.js"}
{add file="comments.js"}
{if !$comments->isEmpty()}
    {assign var="count" value=$comments|@count}
    <div class="commentsTitle">{_ comments_count $count} {$commentFolder->getJip()}</div>
    {foreach from=$comments item=comment}
        <div style="padding-left: {math equation="level * offset - offset" level=$comment->getTreeLevel() offset=45}px;">
            <div class="commentAuthor">{$comment->getUser()->getLogin()} <span class="commentDate">({$comment->getCreated()|date_format:"%e %b %Y, %H:%M"})</span> <a name="comment{$comment->getId()}" href="{url}#comment{$comment->getId()}">#</a> {$comment->getJip()}</div>
            <div class="commentText">
                {$comment->getText()|htmlspecialchars|nl2br}
                <p class="commentAnswer" id="comment_{$comment->getId()}_answer"><a href="{url route="withId" action="post" id=$commentFolder->getId()}?replyTo={$comment->getId()}" onclick="showAnswerForm({$comment->getId()}, {$commentFolder->getId()}); return false;">ответить</a></p>
                <p id="comment_{$comment->getId()}_answerForm"></p>
            </div>
        </div>
    {/foreach}
{else}
    <div class="emptyComments">
        {_ no_comments}
    </div>
{/if}
<br />
{load module="comments" action="post" id=$commentFolder onlyForm=true}