<a href="{url route="galleryAlbum" user=$user->getLogin() album=$album->getId() action="viewAlbum"}">ֲ אכüבמל</a><br />
{foreach from=$photos item="photo_thmb"}
<a href="{url route="galleryPicAction" album=$album->getId() user=$user->getLogin() pic=$photo_thmb->getId() action="view"}">
<img src="{url route="galleryPicAction" album=$album->getId() user=$user->getLogin() pic=$photo_thmb->getId() action="viewThumbnail"}" /></a>
{/foreach}
<h1>{$photo->getName()}{$photo->getJip()}</h1>
<img src="{url route="galleryPicAction" album=$album->getId() user=$user->getLogin() pic=$photo->getId() action="viewPhoto"}">
{load module="comments" section="comments" action="list" id=$photo->getObjId() owner=$album->getGallery()->getOwner()->getId()}