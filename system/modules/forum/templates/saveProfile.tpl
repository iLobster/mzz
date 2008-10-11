{title append="Форум"}
{title append="Редактирование профиля"}
{title append=$profile->getUser()->getLogin()}
<a href="{url route="default2" action="forum"}">Форум</a> / Редактирование профиля пользователя <strong>{$profile->getUser()->getLogin()}</strong>
<br /><br />
{set name="form_action"}{url route="withId" action="editProfile" id=$profile->getId()}{/set}
{form action=$form_action method="post"}
    <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td style="width: 20%; vertical-align: top;">{form->caption name="signature" value="Подпись:"}</td>
            <td style="width: 80%;">{form->textarea name="signature" value=$profile->getSignature() cols="30" rows="6"} {$errors->get('signature')}</td>
        </tr>
        <tr>
            <td>{form->submit name="submit" value="Отправить"}</td>
        </tr>
    </table>
</form>