{assign var="commentFolderId" value=$commentFolder->getId()}
{if !$isReply}
{if $isEdit}<div class="jipTitle">{_ edit_comment}</div>{else}
    <h2 class="addCommentTitle">{_ post_comment}</h2>
{/if}
{form id="commentForm_$commentFolderId" action=$action method="post" jip=$isEdit}
<div class="addCommentForm">
    {form->hidden name="backUrl" value=$backUrl}
    {form->hidden id="replyToField_$commentFolderId" name="replyTo" value=0}
    <span>{_ name}: <b>{$user->getLogin()|h}</b></span>
    {if $errors->has('text')}<span style="color: red; font-weight: bold;">{$errors->get('text')}</span><br />{/if}
    {form->textarea name="text" style="width: 99%;" value=$comment->getText() rows="6" cols="20"}
    <br />
    {form->submit name="submit" value="_ send" style="font-size: 90%; width: auto;  overflow:visible;"} {if $isEdit}{form->reset jip=true name="reset" value="_ simple/cancel" style="font-size: 90%;"}{else}{form->reset name="reset" value="_ simple/cancel" style="font-size: 90%;"}{/if}
</div>
</form>
{else}
<br />
<a href="#" onclick="var tmp = $('commentForm_{$commentFolderId}'); tmp.remove(); $('replyHolder_{$replyTo}').insert(tmp); $('replyToField_{$commentFolderId}').setValue({$replyTo});">ответить</a>
<div id="replyHolder_{$replyTo}"></div>
{/if}