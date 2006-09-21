<?php

// $news        - �������� ������
// $newsMapper  - ��� ������

$news = $newsMapper->searchById(1);

echo $news->getId();                    // 1
echo $news->getTitle();                 // "��������� ��� ������� 1"

$news->setTitle('����� ���������');

echo $news->getTitle();                 // "��������� ��� ������� 1"

$newsMapper->save($news);

echo $news->getTitle();                 // "����� ���������"

?>