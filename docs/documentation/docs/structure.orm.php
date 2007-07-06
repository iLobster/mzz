<p>ORM � mzz ������������ ��� ��������� ������ � ������� � ��. ����������� ������, �������� � ORM �������� ���������� ����������� ������������ - CRUD (Create, Retrieve, Update, Delete).</p>
<p>ORM �������� �� ���� <a href="http://wiki.agiledev.ru/doku.php?id=ooad:dp:data_mapper">The Data Mapper Pattern</a>. �������: � ���������� ����� �������� �� ��������� ����� ��������� - ������ � �������� ������ (��). ���������: �������� ������ - ��������� ��� ������, ������ - ����� ��� ���������� �� �������.��� �������� �� ����������� ����� �������������� ����� ������.</p>
<p>����� �������, ��� �� �������� ������������ ������ ���������� � ������ � �� (� �������� 1 ������). �� ����� �������, ��� �� ��� ���, ���� ������ �� ��� �������� ����������� ������� �������, �� ����� �������� "������" ������ (������ ��, ������� ������ ��������� � ��). �������������� ��� �� �������:</p>
<!-- code 3 -->
<p>DO ����� � �������� �������� ������� ������, ������� - � ����������� <code>mappers</code>.<br />
��� ���������������� The Data Mapper Pattern ����� ����� ���� map - � ������� ��������� ����� (�������� ���������) ������. ����� map ������������� � ����������� <code>maps</code> �������� ������. � ���� ����� ������� ����� �����, ������� ���� � �������, ������� �������� ��, ����� ���������� � ���������, � ����� ��������� ������ ���ORM����. ��������� ������� ����� �������� ���:<br />
<<pre>>[��� ����]
accessor = "��� ���������"
mutator = "��� ��������"
...<br />
&lt;������ �����&gt;<</pre>>
<p>� ���������� ��������� � �������� �� ������ ������, �������� ������ �� ������ ����.</p>
<p>��������� �������������� �����:</p>
<ul>
        <li><p>
                <em>once</em> - e��� ������ ����� ����������� � "true", �� ��� ���� ����� ���� ����������� ���� 1 ���. ������������� ��� �������� �������, ���� �������� - ��� �������� ������� �� ������� ������������. ������� �������������: ��������������� ��� Primary Key (��������: id).</p>
        </li>
        <li>
                <em>owns</em> - ������������ ��� �������� ��������� 1:1.<br />
                ���������:
                <<code ini>>
                        owns = "���_�������.����"
                <</code>>
                ������:
                <<code ini>>
[related_id]
accessor = "getRelated"
mutator = "setRelated"
owns = "related.id"
                <</code>>
                � ���������� ������� ������� ������� (� �������������� � ������) ������� ���������� 1:1 � �������� <code>related</code>. ����� �������������� ����� ����� <code>related_id</code> ������� ������� � ����� <code>id</code> ������� <code>related</code>.<br />
                � ���������� �������� ���� ����� �� ������ � �������� <code>related_id</code> (���������� � ������� �������� <code>getRelated</code>), ����� �������� ���������� ������ <code>related</code> � ������� �������.<br />
                ������ ����������� ����:
                <!-- code 1 -->
                <p>�������������� ������ ������ id ��������������� �������.</p>
        </li>
        <li>
                <em>hasMany</em> - �����, ����������� owns, � ��� ���� ���������, ��� � ������� ������� ��� ����� ������������ ������ ����, �������� Primary Key, � ����� � ���������� ������� ������������ �� ����, � ��������� ��������.<br />
                ������:
                <<code ini>>
[related_id]
accessor = "getRelated"
mutator = "setRelated"
hasMany = "id->related2.relate_id"
                <</code>>
                � ���� ������� <code>related2.relate_id</code> ����� �� �� ��������� �������� ��� � ��� ����� <code>owns</code>, � <code>id</code> (����� �������� ������ ��������� ���� "->") - ���������� ��� ����, �� �������� ���������� ����������<br />
                <p>������ ����������� ���� ��������� ���������� ������� �� owns.</p>
        </li>
        <li>
                <em>section, module, do</em> - ������ �������� ������������ ��������� � owns � hasMany ��� ����, ����� �������, � ��������� ����� ������, ������ ������ � ������ ���� ������ ����������� �������������� DO.<br />
                ��� ����� ������������ �������� � ������, ����� � ��� ������ ������������� ��������� � ������� <code>user_user</code>, ������� � ��������� - <code>news_news</code>. � ������� <code>news</code> ���� <code>editor</code> ���������� ���������� ������������� �������. ������� ������ - <code>news</code>. ��� ���� �������� ���� map ��� DO <code>news</code> ����� ��������� ��������� �������:
                <<code ini>>
[editor]
accessor = "getEditor"
mutator = "setEditor"
owns = "user.id"
section = "user"
module = "user"
do = "other_user"
                <</code>>
                ������ ����������� ����:
                <!-- code 2 -->
                <p>������ ������ ��� ���������� ������������� �������. ������ ������, ������������ ��
                <<code php>>$news->getEditor();<</code>>
                ����� ���������� ������ <i>other_user</i>.
                </p>
        </li>
        <li>
                <em>decorateClass</em> - ������ �������� ������������� ����� ��������� ����� ������������ ��� ������������� ��������<br />
	��������, ��� ���������� ���������� ������:                
                <<code ini>>
[password]
accessor = "getPassword"
mutator = "setPassword"
decorateClass = "md5PasswordHash"
                <</code>>
        </li>
        <li>
                <em>alias</em> - �������� ���������, ����� ���������� ������������ �������.
  
        </li>
</ul>
<p>���������� �������� ������ ��� ������ � ���������:</p>
<ul>
        <li><p>
                <em>save($object)</em> - ���������� ������� $object.</p>
        </li>
        <li><p>
                <em>create()</em> - �������� �������.</p>
        </li>
        <li><p>
                <em>delete($id)</em> - �������� �������, � �������� �������������� ������������ ��������� ���� $id.</p>
        </li>
</ul>
<p>����� ��� �������� ������� ��� ������� ��� ��������� �������:</p>
<ul>
        <li><p>
                <em>searchByKey($id)</em> - ����� ������� �� ���������� �����.</p>
        </li>
        <li><p>
                <em>searchByKeys($id)</em> - ����� �������� �� ��������� ������. � �������� ��������� ��������� ������.</p>
        </li>
        <li><p>
                <em>searchOneByField($name, $value)</em> - ����� ������� �� �������� $value ���� $field.</p>
        </li>
        <li><p>
                <em>searchAllByField($name, $value)</em> - ����� �������� �� �������� $value ���� $field.</p>
        </li>
        <li><p>
                <em>searchOneByCriteria(criteria $criteria)</em> - ����� ������� �� ��������.</p>
        </li>
        <li><p>
                <em>searchAllByCriteria(criteria $criteria)</em> - ����� �������� �� ��������.</p>
        </li>
        <li><p>
                <em>searchAll($orderCriteria = null)</em> - ������� ���� ��������. � �������� ��������� ����� ���� ������� �������� ��� ����������.</p>
        </li>
</ul>
<p>�����������, ��� � ����� �������� �� ������ ��������� ������ ������ ������� ��� ������. ��� �������� searchByLogin (����� ��� ������ ������������ �� ��� ������) ����� ��������� ��������� �������:</p>
<!-- code 4 -->
<<note>>������������ ��������, ������������ � ����������, �� �����. �� ��� ��� ������� ��������� ��������.<</note>>