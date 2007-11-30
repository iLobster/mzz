<?php

// $news        - Доменный Объект
// $newsMapper  - его маппер

$news = $newsMapper->searchById(1);

echo $news->getId();                    // 1
echo $news->getTitle();                 // "Заголовок для новости 1"

$news->setTitle('Новый заголовок');

echo $news->getTitle();                 // "Заголовок для новости 1"

$newsMapper->save($news);

echo $news->getTitle();                 // "Новый заголовок"

?>