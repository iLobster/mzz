������: {$album->getName()}{$album->getJip()}<br />
�����:<br />
{foreach from=$photos item=photo}
    <img src="{url route="galleryPicAction" album=$album->getId() user=$user->getLogin() pic=$photo->getId() action="viewThumbnail"}" />{$photo->getName()}{$photo->getJip()}{$photo->getFile()->getSize()|filesize}
    <hr>
{foreachelse}
    �� ���� ���� �� ���������
{/foreach}