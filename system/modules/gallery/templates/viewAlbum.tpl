{add file="gallery.css"}
{title append=$album->getName()}
{title append=$user->getLogin()}
{title append="Галерея"}

<h3>Альбом «{$album->getName()}» {$album->getJip()}</h3>

<p class="photoCount">{$photos|@sizeof|word_ending:"фотографий,фотография,фотографии"},
в <a href="{url route="withAnyParam" name=$user->getLogin()  action="viewGallery"}">галерее</a> пользователя {$user->getLogin()}</p>


{foreach from=$photos item=photo}
    <div class="albumPhotos">
        <div class="albumPhotoCase">
            <div>
                <a href="{url route="galleryPicAction" album=$album->getId() name=$user->getLogin() id=$photo->getId() action="view"}">
                {*<img src="{url route="galleryPicAction" album=$album->getId() name=$user->getLogin() id=$photo->getId() action="viewThumbnail"}" alt="{$photo->getName()}, {$photo->getFile()->getSize()|filesize}" title="{$photo->getName()}, {$photo->getFile()->getSize()|filesize}" /></a>*}
                <img src="{$photo->getThumbnail()}" alt="{$photo->getName()}, {$photo->getFile()->getSize()|filesize}" title="{$photo->getName()}, {$photo->getFile()->getSize()|filesize}" /></a>
            </div>
        </div>
    {if false}
        <p>0 комментариев{0|word_ending:"комментариев,комментарий,комментария"}</p>
    {/if}
    </div>
{foreachelse}
    В альбоме нет фотографий
{/foreach}

<br clear="all" />