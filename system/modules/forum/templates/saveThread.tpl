{add file="forum.css"}
<div class="forumTopPanel">
    <div class="left"><a href="{url route="default2" action="forum"}">MZZ Forums</a> / <a href="{url route="withId" action="list" id=$forum->getId()}">{$forum->getTitle()}</a> /
    {if $isEdit}
        {title append="Редактирование треда"}
        {title append=$thread->getTitle()}
        Редактирование треда "<strong>{$thread->getTitle()}</strong>"
    {else}
        {title append="Создание нового треда в форуме"}
        {title append=$forum->getTitle()}
        Создание нового треда
    {/if}
    </div>
    <div class="right"><a href="{url route="default2" action="new"}">новые сообщения</a></div>
    <div class="clearRight"></div>
</div>


{form action=$action method="post"}
<table border="0" cellpadding="6" cellspacing="0" class="thread">
    <tr>
        <td colspan="2" class="threadHeader">Новая тема</td>
    </tr>
    <tr class="forumDetails">
        <td class="postInfo forumOddColumn" valign="top">{form->caption name="title" value="Название" onError="style=color: red;"}</td>
        <td class="postContent" valign="top">
            {form->text name="title" size="60" value=$thread->getTitle()}<br />{$errors->get('title')}
        </td>
    </tr>

    <tr class="forumDetails">
        <td class="postInfo forumOddColumn" valign="top">{form->caption name="title" value="Текст сообщения" onError="style=color: red;"}</td>
        <td class="postContent" valign="top">
            {if $isEdit}{assign var="textValue" value=$thread->getFirstPost()->getText()}{else}{assign var="textValue" value=""}{/if}
            {form->textarea name="text" rows="7" cols="50" value=$textValue}
            <br />{$errors->get('text')}
        </td>
    </tr>

    <tr class="forumDetails">
        <td class="postInfo forumOddColumn" valign="top">{form->caption name="sticky" value="Важная тема" onError="style=color: red;"}</td>
        <td class="postContent" valign="top">
            {form->checkbox name="sticky" value=$thread->getIsSticky()} {$errors->get('sticky')}
        </td>
    </tr>

    <tr class="forumDetails">
        <td class="postInfo forumOddColumn" valign="top">{form->caption name="stickyfirst" value="Закрепить первый пост" onError="style=color: red;"}</td>
        <td class="postContent" valign="top">
            {form->checkbox name="stickyfirst" value=$thread->getIsStickyFirst()} {$errors->get('stickyfirst')}
        </td>
    </tr>

    {if $isEdit}
    <tr class="forumDetails">
        <td class="postInfo forumOddColumn" valign="top">{form->caption name="closed" value="Тема закрыта" onError="style=color: red;"}</td>
        <td class="postContent" valign="top">
            {form->checkbox name="closed" value=$thread->getIsClosed()} {$errors->get('closed')}
        </td>
    </tr>
    {/if}

    <tr class="forumDetails">
        <td class="postInfo forumOddColumn" valign="top">
        &nbsp;
        </td>
        <td class="postContent" valign="top">
          {form->submit name="submit" value="Отправить"} {form->reset name="reset" value="Отмена"}
        </td>
    </tr>
</table>
</form>