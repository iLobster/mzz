������: {$album->getName()}{$album->getJip()}<br />
�����:<br />
{foreach from=$photos item=photo}
    <a href="{url route="galleryPicAction" album=$album->getId() user=$user->getLogin() pic=$photo->getId() action="view"}"><img src="{url route="galleryPicAction" album=$album->getId() user=$user->getLogin() pic=$photo->getId() action="viewThumbnail"}" /></a>{$photo->getName()}{$photo->getJip()}{$photo->getFile()->getSize()|filesize}
    <hr>
{foreachelse}
    �� ���� ���� �� ���������
{/foreach}

{load module="comments" section="comments" action="list" id=$album->getObjId() owner=$album->getGallery()->getOwner()->getId()}