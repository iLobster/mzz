�������� tar.gz ����� � http://mzz.ru, ���������� ��� (tar -xszf *.tar.gz) � ������� ���� DocumentRoot ���-������� (�.�. ���� DocumentRoot � ���-������� /home/site/www, �� ���������� ����� � ����� /home/site) ���� �� ������ ���������� mzz � ������, ����� ���������� � ����� �����, ��������� ���-�������.

��� ������������� �������������� ���� www/config.php

���� mzz ���������� �� � ������, �� ������������� �������������� RewriteBase � www/.htaccess � SITE_PATH � www/config.php

���������� ���������� (���� -R) chmod ��� ����� tmp/ � tests/tmp/ ��� ������ PHP-��������.

������������ db/mzz.dump � db/mzz_test.dump (��� ������) � �� MySQL (����� ������������ '���� �������' � phpmyadmin ��� 'mysql < mzz.dump'), ��������� ���� ������ �� ����, ��� ������� ��� ����.
��������! � �������� ������� �������� ������������ �� � ������ mzz � mzz_test.

�� ���� ��������� ���������. ��� �������� ����������������� mzz ������������� ��������� ����� (tests/run.php).