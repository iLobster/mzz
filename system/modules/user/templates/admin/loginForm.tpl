{form action=$form_action method="post" id="userLogin"}
{_ username}: {form->text name="login" size=10 id="loginField" tabindex="1" style="margin: 0px 4px;"}
{_ password}: {form->password name="password" size=10 id="passwordField" tabindex="2" style="margin: 0px 4px;"}
{form->checkbox name="save" text="_ user/remember_login" value="1" tabindex="3"}
{form->hidden name="url" value={url}}{form->submit name="submit" value="_ user/login_process" style="margin: 0px 4px;"}
</form>
