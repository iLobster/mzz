<div class="jipTitle">
{if $isEdit}
    Редактирование треда "<strong>{$thread->getTitle()}</strong>"
{else}
    Создание нового треда в форуме "<strong>{$forum->getTitle()}</strong>"
{/if}
</div>

<form action="{$action}" method="post">
    <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td style='width: 20%;'>{form->caption name="title" value="Название" onError="style=color: red;"}</td>
            <td style='width: 80%;'>{form->text name="title" size="60" value=$thread->getTitle()} {$errors->get('title')}</td>
        </tr>
        <tr>
            <td>{form->caption name="title" value="Текст сообщения" onError="style=color: red;"}</td>
            {if $isEdit}{assign var="textValue" value=$thread->getFirstPost()->getText()}{else}{assign var="textValue" value=""}{/if}
            <td>{form->textarea name="text" rows="7" cols="50" value=$textValue} {$errors->get('text')}</td>
        </tr>
        <tr>
            <td style='width: 20%;'>{form->caption name="sticky" value="Важная тема" onError="style=color: red;"}</td>
            <td style='width: 80%;'>{form->checkbox name="sticky" value=$thread->getIsSticky()} {$errors->get('sticky')}</td>
        </tr>
        {if $isEdit}<tr>
            <td style='width: 20%;'>{form->caption name="closed" value="Тема закрыта" onError="style=color: red;"}</td>
            <td style='width: 80%;'>{form->checkbox name="closed" value=$thread->getIsClosed()} {$errors->get('closed')}</td>
        </tr>{/if}
        <tr>
            <td>{form->submit name="submit" value="Отправить"} {form->reset jip=true name="reset" value="Отмена"}</td>
        </tr>
    </table>
</form>