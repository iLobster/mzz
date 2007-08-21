{foreach from=$galleries item="gallery"}
<p class="pageTitle">������� ����� <strong>{$gallery->getOwner()->getLogin()}{$gallery->getJip()}</strong>:</p>
{foreach from=$gallery->getAlbums() item="album"}
    ������ "{$album->getName()}" ({$album->getPicsNumber()} ����){$album->getJip()}
    <table cellspacing="0" cellpadding="3" class="tableList">
        <thead class="tableListHead">
            <tr>
                <td style="width: 30px;"></td>
                <td style="text-align: left;">��������</td>
                <td style="text-align: left;">��������</td>
                <td style="width: 30px;">����������</td>
                <td style="width: 120px;">����������� �����������</td>
                <td style="width: 30px;">JIP</td>
            </tr>
        </thead>
        {foreach from=$album->getPhotos() item="photo"}
            <tr>
                <td style="text-align: center;"></td>
                <td style="text-align: left;"><a href="{url route="galleryPicAction" album=$album->getId() name=$gallery->getOwner()->getLogin() id=$photo->getId() action="view"}">{$photo->getName()}</a></td>
                <td style="text-align: left;">{$photo->getAbout()}</td>
                <td style="width: 30px;text-align: center;">{$photo->getFile()->getDownloads()}</td>
                <td style="width: 120px;text-align: center;"><a href="{url route="galleryPicAction" album=$album->getId() name=$gallery->getOwner()->getLogin() id=$photo->getId() action="view"}"><img src="{url route="galleryPicAction" album=$album->getId() name=$gallery->getOwner()->getLogin() id=$photo->getId() action="viewThumbnail"}" /></a></td>
                <td style="width: 30px;text-align: center;">{$photo->getJip()}</td>
            </tr>
        {/foreach}
    </table>
{/foreach}
{/foreach}