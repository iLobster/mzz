{title append="Форум"}
{title append="Редактирование профиля"}
{title append=$profile->getUser()->getLogin()}
{add file="forum.css"}
<div class="forumContent">
<div class="forumTopPanel">
    <div class="left">
        <a href="{url route="default2" action="forum"}">MZZ Forums</a>
        <img src="{$SITE_PATH}/templates/images/forum/arrow.gif" width="16" height="8" alt="" />
        Редактирование профиля <strong>{$profile->getUser()->getLogin()}</strong>
    </div>
    <div class="right"><a href="{url route="default2" action="new"}">новые сообщения</a></div>
    <div class="clearRight"></div>
</div>
{set name="form_action"}{url route="withId" action="editProfile" id=$profile->getId()}{/set}

{form action=$form_action method="post"}
    <table border="0" cellpadding="6" cellspacing="0" class="post">
        <tr>
            <td colspan="2" class="threadHeader">Ответить</td>
        </tr>
        <tr>
            <td class="leftSide forumOddColumn" valign="top">
            {form->caption name="signature" value="Подпись:"}
            </td>
            <td class="rightSide" valign="top">
              {form->textarea name="signature" value=$profile->getSignature() cols="30" rows="6"}
              <br />{$errors->get('signature')}
            </td>
        </tr>
        <tr>
            <td class="leftSide forumOddColumn" valign="top">
            &nbsp;
            </td>
            <td class="rightSide" valign="top">
              {form->submit name="submit" value="Отправить"} {form->reset name="reset" value="Отмена"}
            </td>
        </tr>
    </table>
</form>
</div>