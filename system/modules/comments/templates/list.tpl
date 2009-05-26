{add file="comments.css"}
{add file="prototype.js"}
{add file="comments.js"}

<div class="entry-comments">
    <h3>Комментарии <span class="count">({$comments->count()})</span> {$commentsFolder->getJip()}</h3>
    <ul id="comments_{$commentsFolder->getId()}">
    {foreach from=$comments item="comment" name="commentsIteration"}
        {strip}{if !$smarty.foreach.commentsIteration.first}
            {if $comment->getTreeLevel() < $lastLevel}
                {math equation="x - y" x=$lastLevel y=$comment->getTreeLevel() assign="levelDown"}
                {"</li></ul>"|@str_repeat:$levelDown}</li>
            {elseif $lastLevel == $comment->getTreeLevel()}
                </li>
            {else}
                <ul>
            {/if}
        {/if}{/strip}
        <li class="hcomment">
            <div class="entry-comment">{$comment->getText()|h|nl2br}</div>
            <a class="answer" href="{url route="withId" section="comments" action="post" id=$commentsFolder->getId()}?replyTo={$comment->getId()}" onclick="moveCommentForm({$comment->getId()}, {$commentsFolder->getId()}, this); return false;">Ответить</a>
            <ul><li id="answerForm_{$commentsFolder->getId()}_{$comment->getId()}"></li></ul>
        {strip}{assign var="lastLevel" value=$comment->getTreeLevel()}
        {if $smarty.foreach.commentsIteration.last}
            {math equation="x - y" x=$lastLevel y=1 assign="levelDown"}
            {"</li></ul>"|@str_repeat:$levelDown}</li>
        {/if}{/strip}
    {foreachelse}
        <li></li>
    {/foreach}
    </ul>
    {load module="comments" action="post" id=$commentsFolder onlyForm=true}
</div>