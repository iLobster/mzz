<table border="0" cellspacing="0" cellpadding="0"><tr><td>
    <div class="timer">����� ���������: <b>{$timer->getPeriod()|round:5}</b> ���. �������� � ��: <b>{$timer->getQueriesNum()}</b> (<b>{$timer->getQueriesTime()|number_format:5}</b> ���.), ��������������: <b>{$timer->getPreparedNum()}</b></div>
</td><td>
    {$timer->getJip()}
</td></tr></table>