<div class="jipTitle">{_ edit_comment}</div>
{form action=$form_action method="post" jip=true}
<table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
    <tr>
        <td style="width: 20%;">{form->caption name="login" value="Логин:"}</td>
        <td style="width: 80%;">{$comment->getUser()->getLogin()|h}</td>
    </tr>
    <tr>
        <td style="vertical-align: top;">{form->caption name="text" value="Текст"}</td>
        <td>
            {form->textarea name="text" style="width: 99%;" value=$comment->getText() rows="6" cols="20"}
            {if $validator->isFieldError('text')}<div class="error">{$validator->getFieldError('text')}</div>{/if}
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>{form->submit name="submit" value="_ simple/save"} {form->reset jip=true name="reset" value="_ simple/cancel"}</td>
    </tr>
</table>
</form>