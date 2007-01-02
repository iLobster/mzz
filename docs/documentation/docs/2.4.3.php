<p>��� ���������������� mzz ���������� ���������� ��������� ��������� (���������) ��� ���-������� Apache � ����� <code>www/.htaccess</code></p>
<p>�� ��������� ��� ���������� ���������:</p>
<!-- apache code 1 -->

<p>���������� �������� ���������, �������, ��������, ����������� ��������.</p>
<p>
<ul>
<li><code>AddDefaultCharset</code> ���������� ��������� �� ��������� � ������� ����� ���������� �������� ���-��������. �� ��������� <code>windows-1251</code></li>
<li><code>RewriteBase</code> ���������� ������� URL ��� rewrite. ���� mzz ���������� �� � ������, �, ��������, � /site, �� ���������� ������� <code>/site</code>. �� ��������� <code>/</code></li>
<li><code>RewriteCond %{SCRIPT_FILENAME} !-d</code> ��������� rewrite ��� ������������ ����������. �� ��������� ���������������� (���������).</li>
<li>��������� <code>RewriteCond %{REQUEST_URI} !^/mzz/www/?$</code> ���������� ����������������� ������ �����, ����� mzz ���������� �� � ������ ���-�������. ������ <code>/mzz/www</code> ����������� ���� �� �����. �� ��������� ���������������� (���������).</li>
</ul>
</p>
<p>����� ��������� ���������� � .htaccess � ��� ���������� ����� ����� � <a href="http://httpd.apache.org/docs/">����������� Apache</a>.</p>