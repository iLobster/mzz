{title append=$user}
{title append="�������"}
{$gallery->getJip()}<br />
<table border="1" width="100%">
    <tr valign="top">
        <td>
            ��������� �����:<br />
            {foreach from=$photos item=photo}
                <img src="{url route="galleryPicAction" album=$photo->getAlbum()->getId() user=$user pic=$photo->getId() action="viewThumbnail"}" alt="{$photo->getName()} ({$photo->getFile()->getSize()|filesize})" />
            {foreachelse}
                �� ����� ����� �� ���������
            {/foreach}
        </td>
        <td>
            �������:<br />
            {foreach from=$albums item=album}
                <a href="{url route=galleryAlbum user=$user album=$album->getId() action=viewAlbum}">{$album->getName()} ({$album->getPicsNumber()} ����)</a>{$album->getJip()}<br />
            {foreachelse}
                �� ������ ������� �� �������
            {/foreach}
        </td>
    </tr>
</table>