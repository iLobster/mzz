<div class="confirm">
<div class="confirmImg">
<img src="{$SITE_PATH}/templates/images/confirm.gif" hspace="20" vspace="5" /></div>
<div class="confirmMsg">{$message}<br />

<form action="{$url}" method="{$method}" onsubmit="return jipWindow.sendForm(this);">
{if isset($formValues)}
{foreach from=$formValues item=hidden}

{form->hidden value=$hidden[1] name=$hidden[0]}
{/foreach}
{/if}
{form->submit name="submit" value="��"} <span>{form->reset jip=true value="���" name="reset"}</span>
</form>
</div>
</div>