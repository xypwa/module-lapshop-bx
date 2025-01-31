<?php

use Bitrix\Iblock\Component\Tools;
use Bitrix\Main\Loader;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

class ComplexComponent extends CBitrixComponent
{
    protected array $arComponentVariables = [
        'SECTION',
    ];

    public function executeComponent()
    {
        $componentPage = '';
        if ($this->arParams['SEF_MODE'] === 'Y') {
            $componentPage = $this->sefMode();
        } else {
            // not implemented
        }

        //Отдать 404 статус если не найден шаблон
        if (!$componentPage) {
            Tools::process404(
                $this->arParams['MESSAGE_404'],
                ($this->arParams['SET_STATUS_404'] === 'Y'),
                ($this->arParams['SET_STATUS_404'] === 'Y'),
                ($this->arParams['SHOW_404'] === 'Y'),
                $this->arParams['FILE_404']
            );
        }

        $this->IncludeComponentTemplate($componentPage);
    }

    private function sefMode()
    {
        $request = \Bitrix\Main\Context::getCurrent()->getRequest();

        /**
         * Значение масок для шаблонов по умолчанию. - маски без корневого раздела,
         * который указывается в $arParams["SEF_FOLDER"]
         */
        $arDefaultUrlTemplates404 = [
            'list' => '#SECTION_CODE#/',
            'details' => '#SECTION_CODE#/details/#ELEMENT_CODE#/',
        ];

        //В этот массив будут заполнены переменные, которые будут найдены по маске шаблонов url

        $engine = new CComponentEngine($this);
        //Нужно добавлять для парсинга SECTION_CODE_PATH и SMART_FILTER_PATH (жадные шаблоны)
        $engine->addGreedyPart('#SECTION_CODE_PATH#');
        $engine->setResolveCallback(['CIBlockFindTools', 'resolveComponentEngine']);

        //Объединение дефолтных параметров масок шаблонов и алиасов. Параметры из настроек заменяют дефолтные.
        $arUrlTemplates = CComponentEngine::makeComponentUrlTemplates(
            $arDefaultUrlTemplates404,
            $this->arParams['SEF_URL_TEMPLATES']
        );


        $arVariables = [];
//        var_dump(trim($request->getRequestedPage(), $this->arParams['SEF_FOLDER']));
        $urlParts = explode('/', trim($request->getRequestedPage(), $this->arParams['SEF_FOLDER']), 4);
        $urlLevel = count($urlParts);



        switch ($urlLevel) {
            case 1:
                // List of brands
                break;
            case 2:
                // List of models
                $producerId = $urlParts[0];
                $arVariables = [
                    'MANUFACTURER' => $producerId,
                ];
                break;
            case 3:
                // List of laptops
                $producerId = $urlParts[0];
                $modelId = $urlParts[1];
                $arVariables = [
                    'MANUFACTURER' => $producerId,
                    'MODEL' => $modelId,
                ];
                break;
            case 4:
                // Detail page
                $producerId = $urlParts[0];
                $modelId = $urlParts[1];
                $laptopId = $urlParts[2];
                $arVariables = [
                    'MANUFACTURER' => $producerId,
                    'MODEL' => $modelId,
                    'LAPTOP_ID' => $laptopId,
                ];
                break;
        }
        $this->arResult = [
            'VARIABLES' => $arVariables,
        ];
//        var_dump($this->arResult);
        if($arVariables['LAPTOP_ID']) {
            $componentPage = 'details';
        } else {
            $componentPage = 'list';
        }

        //Поиск шаблона
//        $componentPage = $engine->guessComponentPath(
//            $this->arParams['SEF_FOLDER'],
//            $arUrlTemplates,
//            $arVariables
//        );

        return $componentPage;
    }
}