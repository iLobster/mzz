{if $isEdit}
    <div class="jipTitle">{_ edit_comment}</div>
{else}
    <h2 class="addCommentTitle">{_ post_comment}</h2>
{/if}
{form action=$action method="post" jip=$isEdit}
<div class="addCommentForm">
    {form->hidden name="url" value=$url}
    <span>{_ name}: <b>{$userLogin}</b></span>
    {if $errors->has('text')}<span style="color: red; font-weight: bold;">{$errors->get('text')}</span><br />{/if}
    {form->textarea name="text" style="width: 99%;" value=$text rows="6" cols="20"}
    <br />
    {form->submit name="submit" value="_ send" style="font-size: 90%; width: auto;  overflow:visible;"} {if $isEdit}{form->reset jip=true name="reset" value="_ simple/cancel" style="font-size: 90%;"}{else}{form->reset name="reset" value="_ simple/cancel" style="font-size: 90%;"}{/if}
</div>
</form>