<div>Время генерации: {$timer->getPeriod()|round:5} сек. <br />
Запросов к БД {$timer->getQueriesNum()}/{$timer->getPreparedNum()}: {$timer->getQueriesTime()|number_format:5} сек.</div>