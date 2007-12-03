{if $isEdit}
    <div class="jipTitle">Редактирование комментария</div>
{/if}

<h2 class="addCommentTitle">Добавить комментарий</h2>
<form action="{$action}" method="post" {if $isEdit}onsubmit="return jipWindow.sendForm(this);"{/if}>
<div class="addCommentForm">
{form->hidden name="url" value=$url}
<span>Имя: <b>{$userLogin}</b></span>
    {if $errors->has('text')}<span style="color: red; font-weight: bold;">{$errors->get('text')}</span><br />{/if}
    {form->textarea name="text" style="width: 99%;" value=$text rows="6" cols="20"}
    <br />
    {form->submit name="submit" value="Опубликовать комментарий" style="font-size: 90%; width: auto;  overflow:visible;"} {form->reset name="reset" value="Сбросить" style="font-size: 90%;"}
</div>
</form>