<?php
function smarty_resource_page_source($tpl_name, &$tpl_source, &$smarty) {
    $toolkit = systemToolkit::getInstance();
    $pageMapper = $toolkit->getMapper('page', 'page');
    $page = $pageMapper->searchById($tpl_name);

    if ($page) {
        $tpl_source = $page->getContent();
        return true;
    }

    return false;
}

function smarty_resource_page_timestamp($tpl_name, &$tpl_timestamp, &$smarty)
{
    $tpl_timestamp = time();
    return true;
}

function smarty_resource_page_secure($tpl_name, &$smarty) {
    return true;
}

function smarty_resource_page_trusted($tpl_name, &$smarty) {
}
?>