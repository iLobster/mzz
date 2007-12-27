<form action="{$action}" method="post">
    Перенос треда '<strong>{$thread->getTitle()}</strong>' из раздела '<strong>{$thread->getForum()->getTitle()}</strong>' в раздел:
    {form->select name="forum" value=$thread->getForum()->getId() options=$categories} {$errors->get('forum')}<br />
    {form->submit name="submit" value="Переместить"}
</form>