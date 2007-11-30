<form action="{$action}" method="post">
    Перенос треда '<b>{$thread->getTitle()}</b>' из раздела '<b>{$thread->getForum()->getTitle()}</b>' в раздел:
    {form->select name="forum" value=$thread->getForum()->getId() options=$categories}{$errors->get('forum')}<br />
    {form->submit name="submit" value="Переместить"}
</form>