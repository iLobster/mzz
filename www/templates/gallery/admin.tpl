{foreach from=$galleries item="gallery"}
<p class="pageTitle">������� ����� <strong>{$gallery->getOwner()->getLogin()}{$gallery->getJip()}</strong>:</p>
    {foreach from=$gallery->getAlbums() item="album"}
    <ul>
        <li>{$album->getName()} ({$album->getPicsNumber()} ����){$album->getJip()}
            <ul>
            {foreach from=$album->getPhotos() item="photo"}
                <li>{$photo->getName()}{$photo->getJip()}</li>
            {/foreach}
            </ul>
        </li>
    </ul>
    {/foreach}
{/foreach}