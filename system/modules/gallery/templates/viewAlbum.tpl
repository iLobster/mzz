������: {$album->getName()}{$album->getJip()}<br />
�����: {$photos|@sizeof}<br />
{foreach from=$photos item=photo}
    <a href="{url route="galleryPicAction" album=$album->getId() name=$user->getLogin() id=$photo->getId() action="view"}"><img src="{url route="galleryPicAction" album=$album->getId() name=$user->getLogin() id=$photo->getId() action="viewThumbnail"}" alt="{$photo->getName()} {$photo->getFile()->getSize()|filesize}" /></a>{$photo->getJip()}
{foreachelse}
    �� ���� ���� �� ���������
{/foreach}

{load module="comments" section="comments" action="list" id=$album->getObjId() owner=$album->getGallery()->getOwner()->getId()}
