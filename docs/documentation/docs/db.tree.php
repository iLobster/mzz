��� �������� � ������ � ������������ ����������� ������������ ����� dbTreeNS. ���� ����� ������������ ������ � ��������� �� ���������� Nested Sets. ������ � ����� ������� �� ���������� ������ ����� ��������� ��������� ��������.<br />
� ������ ������������ 2 �������, ������� �� ������� - <strong>tree</strong> � <strong>data</strong>.<br />

<ul>
        <li>
                <code>data</code> - � ������� �������� ������.
                ��������� � �������� �������:
                <<code>>
parent - ������������� ������, ������ � ����� tree.id
foo - �������� ��������
path - ���� �� ������ � ������.
                <</code>>
<<note>>
��� ����� � �������� ���������� ���������, �������� ��������� ���������� ����. <br />
�� �������� 1:1 ��������� ����� �������� ������� ������ � ����������� �������� ������������ ������������ �������� ����� ������ ��� �����.
<</note>>
        </li>
        <li>
                <code>tree</code> - ������� ������������ ��� �������� ��������� <br />
                ��������� � �������� �������:
                <<code>>
id - ������������� ������
lkey - ����� ����
rkey - ������ ����
level - ������� ���� � ������ (root - ������ �������)
                <</code>>
        </li>
</ul>
<p>��� ������ � ��������� �������������� ����� <code>simpleMapperForTree</code> � �������� ������� ���� <code>simpleForTree</code>. <code>simpleMapperForTree</code> ������������� ��������� ������:</p>

<ul>
        <li><code>setTree($tree_id)</code> - ����� ��������� id ������. ������������, ����� � ������������� ������ ������ �������� ��������� ��������.</li>
        <li><code>searchByPath($path)</code> - ����� �������� �� ����.</li>
        <li><code>getFolders(simpleForTree $id, $level = 1)</code> - �������� ��������� ��� ������ <code>getBranch()</code>.</li>
        <li><code>getBranch(simpleForTree $id, $level = 1)</code> - ������� �����������. ������ ���������� ��������� ������� ����, � ������ - ������� �������.</li>
        <li><code>getParentBranch(simpleForTree $node)</code> - ������� ������������ �����.</li>
        <li><code>getTreeParent(simpleForTree $child)</code> - ������� ������������� ��������.</li>
</ul>

<p>��������� ������ ����� ������ ����������� �� <a href="modules.simple.html#modules.simple.simpleMapper"><code>simpleMapper</code></a>'a.</p>

<p>� ������ <code>simpleForTree</code> ���� ��������� ������ ��� ������ � ���������:</p>

<ul>
        <li><code>getTreeLevel()</code> - ������� ����.</li>
        <li><code>getTreeKey()</code> - �������� ���������� ����� ����.</li>
        <li><code>getTreeId()</code> - id ������, � ������ ����� � ������ ������ �������� ��������� ��������.</li>
        <li><code>getTreeParent()</code> - ��������� ������������� �������� �������� ����.</li>
        <li><code>getPath($simple = true)</code> - ��������� ���� �� ����. ������������ �������� ��������� ������ ��������, � ������ <code>true</code> - ������������ "�������" ����, � �������� ��������� ��� ��������� ��������, <code>false</code> - ������ ����.</li>
</ul>

<p>� ��������� ������ � ������� <code>simpleForTree</code> ���������� ������ � ����� ����������� ������ <a href="modules.simple.html#modules.simple.simple"><code>simple</code></a>.</p>

<p>��������� ������ ������������ � ������� ��������������� ������ <code>simpleMapperForTree::getTreeParams()</code>, ������� �� ��������� ���������� ������ ���������� ����:</p>
<<code php>>
protected function getTreeParams()
{
        return array('nameField' => 'name', 'pathField' => 'path', 'joinField' => 'parent', 'tableName' => $this->table . '_tree', 'treeIdField' => 'tree_id');
}
<</code>>

<p>� ���������� ������ ����� ����� ���������� ������, ���������� ���� ����� ������, � ���� ������ ����������� �������� ����� ������������ �� ������� �� ���������. ����� � ���� ������� ���������� ���������:</p>

<ul>
        <li><code>nameField</code> - ����, ���������� � ���� ��� ����.</li>
        <li><code>pathField</code> - ����, ���������� � ���� ���� �� ����. ���� �������� � �������������� �������������, ��������� ������ ���� <code>nameField</code></li>
        <li><code>joinField</code> - ����, ����������� ������� ������ � �������� ���������.</li>
        <li><code>tableName</code> - ��� �������, �������� ��������� ������.</li>
        <li><code>treeIdField</code> - ��� ����, � ������� ����� ��������� id ������ (� ������, ����� �������� ���������).</li>
</ul>
