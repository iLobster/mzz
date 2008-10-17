{add file="forum.css"}
<div class="forumTopPanel">
    <div class="left">
        <a href="{url route="default2" action="forum"}">MZZ Forums</a> /
        <a href="{url route=withId action=thread id=$thread->getId()}">{$thread->getTitle()}</a> / Перемещение
    </div>
    <div class="right"><a href="{url route="default2" action="new"}">новые сообщения</a></div>
    <div class="clearRight"></div>
</div>

{form action=$action method="post"}
<table border="0" cellpadding="6" cellspacing="0" class="thread">
    <tr>
        <td colspan="2" class="threadHeader">Переместить из "{$thread->getForum()->getTitle()}"</td>
    </tr>
    <tr class="forumDetails">
        <td class="postInfo forumOddColumn" valign="top">
        {form->caption name="forum" value="В раздел" onError="style=color: red;"}
        </td>
        <td class="postContent" valign="top">
            {form->select name="forum" value=$thread->getForum()->getId() options=$categories}<br />{$errors->get('forum')}
        </td>
    </tr>
    <tr class="forumDetails">
        <td class="postInfo forumOddColumn" valign="top">

        &nbsp;
        </td>
        <td class="postContent" valign="top">
          {form->submit name="submit" value="Переместить"}
        </td>
    </tr>
</table>

</form>