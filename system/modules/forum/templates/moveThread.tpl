<form action="{$action}" method="post">
    ������� ����� '<b>{$thread->getTitle()}</b>' �� ������� '<b>{$thread->getForum()->getTitle()}</b>' � ������:
    {form->select name="forum" value=$thread->getForum()->getId() options=$categories}{$errors->get('forum')}<br />
    {form->submit name="submit" value="�����������"}
</form>