{foreach from=$galleries item="gallery"}
<p class="pageTitle">������� ����� <strong>{$gallery->getOwner()->getLogin()}{$gallery->getJip()}</strong>:</p>
    {foreach from=$gallery->getAlbums() item="album"}
    <ul>
        <li>������ "{$album->getName()}" ({$album->getPicsNumber()} ����){$album->getJip()}
            <ul>
            {foreach from=$album->getPhotos() item="photo"}
                {assign var="owner" value=$gallery->getOwner()->getLogin()}
                <li><a href="{url route="galleryPicAction" name=$owner album=$album->getId() id=$photo->getId() action="view"}" target="_blank">{$photo->getName()}</a>{$photo->getJip()}</li>
            {/foreach}
            </ul>
        </li>
    </ul>
    {/foreach}
{/foreach}