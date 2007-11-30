{add file="gallery.css"}

Альбом <a href="{url route="galleryAlbum" name=$user->getLogin() album=$album->getId() action="viewAlbum"}">{$album->getName()}</a>{$album->getJip()}<br />
{foreach from=$photos item="photo_thmb"}
    <a href="{url route="galleryPicAction" album=$album->getId() name=$user->getLogin() id=$photo_thmb->getId() action="view"}">
    <img src="{$SITE_PATH}{$photo_thmb->getThumbnail()}" alt="{$photo_thmb->getName()} ({$photo_thmb->getFile()->getSize()|filesize})" /></a>
{/foreach}
<h2>{$photo->getName()}{$photo->getJip()}</h2>
<img src="{url route="galleryPicAction" album=$album->getId() name=$user->getLogin() id=$photo->getId() action="viewPhoto"}"><br />
{$photo->getAbout()}<br />
Просмотров изображения: {$photo->getFile()->getDownloads()}
{load module="comments" section="comments" action="list" id=$photo->getObjId() owner=$album->getGallery()->getOwner()->getId()}