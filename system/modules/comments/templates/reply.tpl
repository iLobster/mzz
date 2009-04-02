<h2 class="addCommentTitle">Ответить на комментарий</h2>
{form action=$action method="post"}
<div class="addCommentForm">
    {form->hidden name="backUrl" value=$backUrl}
    <span>{_ name}: <b>{$user->getLogin()|h}</b></span>
    {if $errors->has('text')}<span style="color: red; font-weight: bold;">{$errors->get('text')}</span><br />{/if}
    {form->textarea name="text" style="width: 99%;" value=$comment->getText() rows="6" cols="20"}
    <br />
    {form->submit name="submit" value="_ send" style="font-size: 90%; width: auto;  overflow:visible;"} {form->reset name="reset" value="_ simple/cancel" style="font-size: 90%;"}
</div>
</form>