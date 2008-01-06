<a href="{url route="default2" action="forum"}">Форум</a> / <a href="{url route="withId" action="list" id=$forum->getId()}">{$forum->getTitle()}</a> /
{if $isEdit}
    {title append="Редактирование треда"}
    {title append=$thread->getTitle()}
    Редактирование треда "<strong>{$thread->getTitle()}</strong>"
{else}
    {title append="Создание нового треда в форуме"}
    {title append=$forum->getTitle()}
    Создание нового треда
{/if}

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
        <tr>
            <td style='width: 20%;'>{form->caption name="stickyfirst" value="Закрепить первый пост" onError="style=color: red;"}</td>
            <td style='width: 80%;'>{form->checkbox name="stickyfirst" value=$thread->getIsStickyFirst()} {$errors->get('stickyfirst')}</td>
        </tr>
        {if $isEdit}<tr>
            <td style='width: 20%;'>{form->caption name="closed" value="Тема закрыта" onError="style=color: red;"}</td>
            <td style='width: 80%;'>{form->checkbox name="closed" value=$thread->getIsClosed()} {$errors->get('closed')}</td>
        </tr>{/if}
        <tr>
            <td>{form->submit name="submit" value="Отправить"}</td>
        </tr>
    </table>
</form>