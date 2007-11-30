{add file="gallery.css"}
{title append=$user}
{title append="Галерея"}
<h3>Альбомы пользователя {$user}{$gallery->getJip()}</h3>


{foreach from=$albums item="album"}
    <div class="albums">
        <div class="albumCase">
            <div>
                <a href="{url route=galleryAlbum name=$user album=$album->getId() action=viewAlbum}">
                {*<img {if $album->getMainPhoto()}class="albumThumb" src="{url route="galleryPicAction" album=$album->getId() name=$user id=$album->getMainPhoto()->getId() action="viewThumbnail"}{else}src="{$SITE_PATH}/templates/images/gallery/empty.gif{/if}" alt="{$album->getName()}" title="{$album->getName()}" /></a>*}
                <img {if $album->getMainPhoto()}class="albumThumb" src="{$album->getMainPhoto()->getThumbnail()}"}{else}src="{$SITE_PATH}/templates/images/gallery/empty.gif{/if}" alt="{$album->getName()}" title="{$album->getName()}" /></a>
            </div>
        </div>
        <h4><a href="{url route=galleryAlbum name=$user album=$album->getId() action=viewAlbum}" title="{$album->getName()|addslashes}">{if strlen($album->getName()) > 15}{$album->getName()|htmlspecialchars|substr:0:12}...{else}{$album->getName()|htmlspecialchars}{/if}</a></h4>
        <p><b>{$album->getPicsNumber()}</b> фото {$album->getJip()}</p>
    </div>
{foreachelse}
     Альбомов у пользователя нет.
{/foreach}

<br clear="all" />