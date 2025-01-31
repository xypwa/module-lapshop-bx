<?php

define("BX_SKIP_USER_LIMIT_CHECK", true);
define('STOP_STATISTICS', true);
define('PUBLIC_AJAX_MODE', true);
define('BX_SECURITY_SHOW_MESSAGE', false);
define("NOT_CHECK_PERMISSIONS", true);
define('NO_KEEP_STATISTIC', 'Y');
define('NO_AGENT_STATISTIC','Y');
define('NO_AGENT_CHECK', true);
define('DisableEventsCheck', true);
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

use Bitrix\Main\Application;
use Cwr\Watrix\Main\Watrix;
use Bitrix\Main\Loader;

$request = Application::getInstance()->getContext()->getRequest();

$requestData = getRequestBody($request);
if($requestData && Loader::includeModule('xypw.watrix')) {

//    file_put_contents(__FILE__.".log", print_r($requestData, true), 8);
    $WatrixInst = new Watrix();
    $WatrixInst->handleWebhook($requestData);
}

function getRequestBody($request) {
    $result = [];
    $bodyRaw = $request->getJsonList();
    if($bodyRaw) {
        if($bodyValues = $bodyRaw->getValues()) {
            $result = $bodyValues;
        }
    }
    return $result;
}