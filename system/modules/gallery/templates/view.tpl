{add file="gallery.css"}
{add file="prototype.js"}
{add file="prototype_improvements.js"}
{add file="scroller.js"}
<table border="0" cellpadding="0" cellspacing="5" width="99%">
    <tr valign="top">
        <td class="photoMainView"><h2 class="photoName">{$photo->getName()}{$photo->getJip()}</h2></td>
        <td>&nbsp;</td>
    </tr>
    <tr valign="top">
        <td class="photoMainView">
            <img src="{url route="galleryPicAction" album=$album->getId() name=$user->getLogin() id=$photo->getId() action="viewPhoto"}" alt="" /><br />
            {load module="comments" section="comments" action="list" id=$photo->getObjId() owner=$album->getGallery()->getOwner()->getId()}
        </td>
        <td>

        <div class="photoAlbumName">
        Альбом <a href="{url route="galleryAlbum" name=$user->getLogin() album=$album->getId() action="viewAlbum"}">{$album->getName()}</a>{$album->getJip()}
        </div>

        <div class="albumPhotoThumbs">

        <table border="0" cellpadding="1" cellspacing="0" id="albumPhotoPreviews">
        <tr>
         {foreach from=$photos item="photo_thmb"}
            <td><a href="{url route="galleryPicAction" album=$album->getId() name=$user->getLogin() id=$photo_thmb->getId() action="view"}">
            <img {if $photo->getId() == $photo_thmb->getId()}class="currentPhoto"{/if}src="{$SITE_PATH}{$photo_thmb->getThumbnail()}" alt="{$photo_thmb->getName()} ({$photo_thmb->getFile()->getSize()|filesize})" /></a>
            </td>
        {/foreach}
        </tr>
        </table>

        <a href="" style="display: none;" onmousedown="albumPhotoPreviewsScroller.startScroll('right');" onmouseup="albumPhotoPreviewsScroller.stopScroll();" onclick="return false;"><img src="{$SITE_PATH}/templates/images/gallery/prev.gif" alt="" width="14" height="13" style="float: left;" class="previewScroll" /></a>
        <a href="" {if count($photos) < 4}style="display: none;" {/if}onmousedown="albumPhotoPreviewsScroller.startScroll();" onmouseup="albumPhotoPreviewsScroller.stopScroll();" onclick="return false;"><img src="{$SITE_PATH}/templates/images/gallery/next.gif" alt="" width="14" height="13" style="float: right;" class="previewScroll" /></a>
        </div>
        <div class="clear"></div>
        <div class="photoDescription">{$photo->getAbout()}</div>
        <div class="photoAddonDescription">
            <strong>Дополнительная информация</strong><br />
            <ul>
              <li>Загружено: {$photo->getFile()->getModified()|date_format:"%e %B %Y, %H:%M"}</li>
              <li>Просмотрено: {$photo->getFile()->getDownloads()}</li>
            </ul>
        </div>
        </td>
    </tr>
</table>

<script type="text/javascript">
var albumPhotoPreviewsScroller = new photoPreviewsScroller('albumPhotoPreviews');
</script>
