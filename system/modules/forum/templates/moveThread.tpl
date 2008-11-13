{add file="forum.css"}
<div class="forumTopPanel">
    <div class="left">
        <a href="{url route="default2" action="forum"}">MZZ Forums</a>
        <img src="{$SITE_PATH}/templates/images/forum/arrow.gif" width="16" height="8" alt="" />
        <a href="{url route=withId action=thread id=$thread->getId()}">{$thread->getTitle()}</a>
        <img src="{$SITE_PATH}/templates/images/forum/arrow.gif" width="16" height="8" alt="" />
        Перемещение
    </div>
    <div class="right">{include file="forum/forumMenu.tpl"}</div>
    <div class="clearRight"></div>
</div>

{form action=$action method="post"}
<table border="0" cellpadding="6" cellspacing="0" class="post">
    <tr>
        <td colspan="2" class="threadHeader">Переместить из "{$thread->getForum()->getTitle()}"</td>
    </tr>
    <tr>
        <td class="leftSide forumOddColumn" valign="top">
        {form->caption name="forum" value="В раздел" onError="style=color: red;"}
        </td>
        <td class="rightSide" valign="top">
            {form->select name="forum" value=$thread->getForum()->getId() options=$categories}<br />{$errors->get('forum')}
        </td>
    </tr>
    <tr>
        <td class="leftSide forumOddColumn" valign="top">

        &nbsp;
        </td>
        <td class="rightSide" valign="top">
          {form->submit name="submit" value="Переместить"}
        </td>
    </tr>
</table>

</form>