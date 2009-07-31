{assign var="commentsFolderId" value=$commentsFolder->getId()}
<h3><a href="{url route="withId" module="comments" action="post" id=$commentsFolderId}" class="selected" onclick="comments.moveForm(0, {$commentsFolderId}, this); return false;">{_ post_comment}</a></h3>
<div id="answerForm_{$commentsFolderId}_0">
    {if $hideForm}{assign var="formStyle" value="display: none;"}{else}{assign var="formStyle" value=""}{/if}
    {form id="commentForm_$commentsFolderId" action=$action style=$formStyle  method="post" onsubmit="comments.postForm(this); return false;"}
        {include file="comments/postForm.tpl"}
    </form>
</div>