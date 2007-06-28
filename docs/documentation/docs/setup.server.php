<p>���� ������� ��� �������� � ������������ ����� mzz (<a href="http://www.mzz.ru">http://www.mzz.ru</a>), �� ����� ���������� ���������� ����������� ����� � �������� ����� �� ��������� ������.
� UNIX-�������� ������������ ������� ��� ���������� ����������� ������ � ������ ���-������� (��������, htdocs) ������������ ��������� ������:
<<code bash>>
tar -xvzf <��� ������>.tar.gz htdocs/
<</code>></p>



<p>����� ���������� ��������� <a href="setup.configuration.html">���������</a> � ����� <code>www/config.php</code> �, ���� ���������, �������� �� �� ����.</p>

<p>���� mzz ���������� �� � ������ ���-�������, �� ���������� � <code>SITE_PATH</code> ������� URL-����.</p>

<p>��������, DocumentRoot � ������������ ���-������� Apache ����� �������� <code>c:\www</code>, mzz ���������� � <code>c:\www\sites\mzz</code>. �������������� URL ����� ����� �������� ��������� ���: <code>http://localhost/sites/mzz/</code>. � ����� ������ <code>SITE_PATH</code> ������ ����� �������� <code>/sites/mzz</code>, � <code>www/.htaccess</code> ��������� ��������� ���������:
<<code apache>>
#....
RewriteBase /sites/mzz
#....
RewriteCond %{REQUEST_URI} !^/sites/mzz/?$
#....
<</code>>

</p>


<p><strong>��������� ���: ��������� ���� ������� �� ����� � �����.</strong> � ���� �� ��� ��� ������, ������������� ���� �� ����������. ��� ������� �� �������� ������������ � �������� �������-����������. ��� �������� ����� ����� �� ������ ���������� ������ ���������� <code>tmp/</code> � �� �����������. �� ����� ���������� ������� ����������� ����� �� ������ ��� ���������� <code>tests/tmp/</code>, <code>system/modules</code>,  <code>www/modules</code> � �� �����������. ������ ����� ������� ����� 777 (rwxrwxrwx).</p>

<p>��������� ������ � ������ ��������� ������ ����� �� ������, ���� ����� �������� 644 (rw-r--r--) - ��� ������, 755 (rwxr-xr-x) - ��� �����.</p>

<p>�������������� ����� ����� <strong>������ ������ � ������ � MySQL</strong>, ������� �������� � ������ <code>db/mzz.sql</code> � <code>db/mzz_test.sql</code> (��� ������). ������� ��� ����� ����� phpmyadmin ��� �������:
<<code bash>>mysql < mzz.sql
mysql < mzz_test.sql<</code>>
</p>

<<note>>� �������� ������� �������� ������������ �� � ������� "mzz" � "mzz_test". ��� ������������� ������� ����� ���� ������ �������������� � /db/mzz.sql ��� /db/mzz_test.sql ��� ���� ������ � ��������: DROP DATABASE, CREATE DATABASE, USE.<</note>>
<p>�� ���� ��������� ���������. ��� �������� ����������������� mzz ������������� ��������� ����� (� ����� ������� �� URL <code>http://localhost/sites/mzz/tests/run.php</code>).</p>