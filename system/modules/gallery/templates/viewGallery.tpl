{add file="gallery.css"}
{title append=$user}
{title append="_ gallery"}
<h3>{_ albums_of_user $user}{$gallery->getJip()}</h3>

{foreach from=$albums item="album"}
    <div class="albums">
        <div class="albumCase">
            <div>
                <a href="{url route=galleryAlbum name=$user album=$album->getId() action=viewAlbum}">
                {*<img {if $album->getMainPhoto()}class="albumThumb" src="{url route="galleryPicAction" album=$album->getId() name=$user id=$album->getMainPhoto()->getId() action="viewThumbnail"}{else}src="{$SITE_PATH}/templates/images/gallery/empty.gif{/if}" alt="{$album->getName()}" title="{$album->getName()}" /></a>*}
                <img {if $album->getMainPhoto()}class="albumThumb" src="{$SITE_PATH}/{$album->getMainPhoto()->getThumbnail()}"{else}src="{$SITE_PATH}/templates/images/gallery/empty.gif"{/if} alt="{$album->getName()}" title="{$album->getName()}" /></a>
            </div>
        </div>
        <h4><a href="{url route=galleryAlbum name=$user album=$album->getId() action=viewAlbum}" title="{$album->getName()|addslashes}">{$album->getName()|htmlspecialchars}</a></h4>
        <p><b>{_ photos_count $album->getPicsNumber()}</b> {$album->getJip()}</p>
    </div>
{foreachelse}
     {_ no_album}
{/foreach}

<div class="clear"></div>
