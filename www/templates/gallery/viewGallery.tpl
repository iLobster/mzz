�������:
{foreach from=$albums item=album}
    <a href="{url route=galleryAlbum user=$user album=$album->getId() action=viewAlbum}">{$album->getName()} ({$album->getPicsNumber()} ����)</a><br />
{foreachelse}
    �� ������ ������� �� �������
{/foreach}