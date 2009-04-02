{assign var="commentFolderId" value=$commentsFolder->getId()}
<h2 class="addCommentTitle commentAnswer" id="comment_0_answer"><a href="{url route="withId" action="post" id=$commentFolderId}" onclick="showAnswerForm(0, {$commentFolderId}); return false;">{_ post_comment}</a></h2>
<p id="comment_0_answerForm">
{form id="commentForm_$commentFolderId" action=$action method="post"}
<div class="addCommentForm">
    {form->hidden name="backUrl" value=$backUrl}
    <span>{_ name}: <b>{$user->getLogin()|h}</b></span>
    {if $errors->has('text')}<span style="color: red; font-weight: bold;">{$errors->get('text')}</span><br />{/if}
    {form->textarea name="text" style="width: 99%;" value=$comment->getText() rows="6" cols="20"}
    <br />
    {form->submit name="submit" value="_ send"}
</div>
</form>
</p>