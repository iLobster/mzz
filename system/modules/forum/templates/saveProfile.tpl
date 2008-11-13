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
    <div class="right">{include file="forum/forumMenu.tpl"}</div>
    <div class="clearRight"></div>
</div>
{set name="form_action"}{url route="withId" action="editProfile" id=$profile->getId()}{/set}
{form action=$form_action method="post" enctype="multipart/form-data"}
    <table border="0" cellpadding="6" cellspacing="0" class="post">
        <tr>
            <td class="threadHeader">Редактирование профиля</td>
        </tr>
        <tr>
            <td class="leftSide forumOddColumn" valign="top">
            {if !$errors->isEmpty()}
                <div class="formError">
                <strong>Допущены ошибки при заполнении формы.</strong><br />
                Исправьте отмеченные поля и отправьте форму еще раз.
                <ul>
                {foreach from=$errors->export() item=formError}
                    <li>{$formError}</li>
                {/foreach}
                </ul>
                </div>
            {/if}
              <div class="userProfileFormField">
                  <span class="userProfileFormLabel">{form->caption name="location" value="Город:"}</span>
                  <span class="userProfileFormInput">{form->text name="location" value=$profile->getLocation()}
                  <br />{$errors->get('location')}</span>
              </div>

              <div class="userProfileFormField">
                  <span class="userProfileFormLabel">{form->caption name="icq" value="ICQ:"}</span>
                  <span class="userProfileFormInput">{form->text name="icq" value=$profile->getIcq()}
                  <br />{$errors->get('icq')}</span>
              </div>

              <div class="userProfileFormField">
                  <span class="userProfileFormLabel">{form->caption name="url" value="URL:"}</span>
                  <span class="userProfileFormInput">{form->text name="url" value=$profile->getUrl()}
                  <br />{$errors->get('url')}</span>
              </div>

              <div class="userProfileFormField">
                  <span class="userProfileFormLabel">{form->caption name="birthday" value="Дата рождения (д/м/г):"}</span>
                  <span class="userProfileFormInput">{form->text name="birthday[day]" size="2" value=$profile->getBirthdayDay()} / {form->text name="birthday[month]" value=$profile->getBirthdayMonth() size="2"} / {form->text name="birthday[year]" value=$profile->getBirthdayYear() size="4"}
                  <br />{$errors->get('birthday')}</span>
              </div>

              <div class="userProfileFormField">
                  <span class="userProfileFormLabel">{form->caption name="signature" value="Подпись:"}</span>
                  <span class="userProfileFormInput">{form->textarea name="signature" value=$profile->getSignature() cols="30" rows="6"}
                  <br />{$errors->get('signature')}</span>
              </div>
              <div class="userProfileFormField">
                  <span class="userProfileFormLabel">{form->caption name="avatar" value="Аватар:"}<br />
                  </span>
                  <span class="userProfileFormInput">
                    {if $profile->getAvatar()}
                    {form->checkbox name="delete_avatar" onclick="$('avatar_file').toggle();" value=0 values="0|1" text="Удалить аватар"}
                    <br />
                    {/if}
                    {form->file name="avatar" id="avatar_file"}
                    <div class="userProfileNotice">
                    Максимальный размер аватара 100х100{if $folder->getFilesize()} и {$folder->getFilesize()|filesize}{/if}. <br />
                    Разрешены только {$folder->getExts()} файлы.
                    </div>
                    <br />{$errors->get('avatar')}
                  </span>
              </div>
              <div class="clear"></div>
              <div class="userProfileFormButtons">
              {form->submit name="submit" value="Отправить"} {form->reset name="reset" value="Отмена"}
              </div>
            </td>
        </tr>
    </table>
</form>
</div>