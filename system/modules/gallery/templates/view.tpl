{add file="gallery.css"}
{add file="prototype.js"}
{add file="prototype_improvements.js"}
{add file="scroller.js"}
{add file="marker.css"}
{add file="rectmarquee.js"}


{literal}
<script type="text/javascript">
var imageId = 'galleryPhoto';
var MarqueeTool = null;
function createMarqueeTool()
{
    $('tagDoneButton').show();
    MarqueeTool = new Marquee(imageId, {toolbar: imageId + 'Tag', color: '#444', opacity: 0.4});

    MarqueeTool.setOnUpdateCallback(function () {
        var coords = MarqueeTool.getCoords();
        coords = coords.x1 + ',' + coords.y1 + ',' + coords.width + ',' + coords.height;
        if ($('tagCoords')) {
            $('tagCoords').value = coords;
        }
    });
}

function destroyMarqueeTool()
{
    if (!MarqueeTool) return;
    MarqueeTool.hide();
    MarqueeTool = null;
}

//Event.observe(window, 'load', createMarqueeTool);
function gallerySaveTag(form)
{
    form = $(form);
    var coords = $F('tagCoords').split(',');
    $('tagSaveError').update('');
    var div = form.up('div');
    var content = div.innerHTML;
    div.update('Подождите...');
    form.request({
        onComplete: function(transport) {// alert(transport.responseText);
            if (transport.responseText.match(/^1$/)) {

                tagCoords[tagCoords.length] = [parseInt(coords[0]), parseInt(coords[1]), parseInt(coords[0]) + parseInt(coords[2]), parseInt(coords[1]) + parseInt(coords[3]), $F(form.getInputs('text', 'tag')[0])];
                //alert(tagCoords[tagCoords.length-1]);

                var newTag = new Template(newTagTpl);
                var vars = {x: coords[0], y: coords[1], w: coords[2], h: coords[3], tag: $F(form.getInputs('text', 'tag')[0])};
                $($$('div.tagList')[0]).insert((tagCoords.length > 1 ? ', ' : '') + newTag.evaluate(vars));
                destroyMarqueeTool();
                createMarqueeTool();
            }
            else {
                div.update(content);
                $('tagSaveError').update('Ошибка! Метка не сохранена. <br />');
            }
        }
    });
    return false;
}
</script>
{/literal}

<table border="0" cellpadding="0" cellspacing="5" width="99%">
    <tr valign="top">
        <td class="photoMainView"><h2 class="photoName">{$photo->getName()}{$photo->getJip()}</h2></td>
        <td>&nbsp;</td>
    </tr>
    <tr valign="top">
        <td id="tagDoneButton" style="display: none;">Когда закончите отмечать нажмите <input type="button" value="Готово" onclick="destroyMarqueeTool(); $('tagDoneButton').hide();" /></td>
        <td></td>
    </tr>
    <tr valign="top">
        <td class="photoMainView">
            <span style="position: absolute; display: none; background-color: #fff; border: 1px solid black; padding: 3px;" ></span>
            <img id="galleryPhoto" src="{if !$photo->getFile()}{$SITE_PATH}/files/gallery/notfound.jpg{else}{url route="galleryPicAction" album=$album->getId() name=$user->getLogin() id=$photo->getId() action="viewPhoto"}{/if}" alt="" /><br />

            {load module="comments" section="comments" action="list" id=$photo->getObjId() owner=$album->getGallery()->getOwner()->getId()}
        </td>
        <td>

        <div class="photoAlbumName">
        {_ album} <a href="{url route="galleryAlbum" name=$user->getLogin() album=$album->getId() action="viewAlbum"}">{$album->getName()}</a>{$album->getJip()}
        </div>

        <div class="albumPhotoThumbs">

        <table border="0" cellpadding="1" cellspacing="0" id="albumPhotoPreviews">
        <tr>
         {foreach from=$photos item="photo_thmb"}
            <td><a href="{url route="galleryPicAction" album=$album->getId() name=$user->getLogin() id=$photo_thmb->getId() action="view"}">
            <img {if $photo->getId() == $photo_thmb->getId()}class="currentPhoto"{/if}src="{$SITE_PATH}{$photo_thmb->getThumbnail()}" alt="{$photo_thmb->getName()} {if $photo_thmb->getFile()}({$photo_thmb->getFile()->getSize()|filesize}){/if}" /></a>
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
            <strong>{_ additional_info}</strong><br />
            <ul>
              {if $photo->getFile()}<li>{_ date_of_uploading}: {$photo->getFile()->getModified()|date_format:"%e %B %Y, %H:%M"}</li>
              <li>{_ viewed}: {$photo->getFile()->getDownloads()}</li>{/if}
            </ul>
        </div>
        </td>
    </tr>
</table>
<a href="#" onclick="if (!MarqueeTool) createMarqueeTool();">отметить</a>
{load module="tags" section="tags" action="list" parent_id=$photo->getObjId() coords=true}
<script type="text/javascript">
var albumPhotoPreviewsScroller = new photoPreviewsScroller('albumPhotoPreviews');
</script>

<div id="galleryPhotoTag" style="z-index: 999; display: none; position: absolute; width: 180px;">
    <img src="{$SITE_PATH}/templates/images/arrow_left.gif" width="9" height="17" alt="" style="float: left; margin-top: 8px;" />
    <div style="float: right;border: 2px solid #555555; background-color: #FBFBFB; width: 167px;">
        <div style="padding: 5px; background-color: #FCF8C9; border-bottom: 1px solid #F4E846;">Введите метку</div>
            <div style="padding: 10px;">
            <div id="tagSaveError" style="color: red; font-weight: bold;"></div>
            {form->open action=$tagLink method="post" onsubmit="return gallerySaveTag(this)"}
            {form->hidden name="ajaxAction" value="tag"}
            {form->hidden name="coords" id="tagCoords" value="0,0,0,0"}
            {form->text name="tag" value=""}
            <p>{form->submit name="saveTag" value="Отметить"}</p>
            </form>7
            </div>
    </div>
    <img src="{$SITE_PATH}/templates/images/arrow_right.gif" width="9" height="17" alt="" style="display: none; float: right; margin-top: 8px;" />
    <div class="clear"></div>
</div>