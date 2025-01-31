<?php

use Bitrix\Main\ArgumentNullException;
use Bitrix\Main\ArgumentOutOfRangeException;
use Bitrix\Main\Loader;
use Bitrix\Main\LoaderException;
use Bitrix\Main\SystemException;
use Bitrix\Main\Application;
use Xypw\Lapshop\Main;
use Bitrix\Main\ORM\Query\Query;
use Xypw\Lapshop\Laptop;


class LapshopDetailsComponent extends CBitrixComponent
{

    public function __construct($component = null)
    {
        parent::__construct($component);
    }

    /**
     * @return mixed|void|null
     * @throws LoaderException
     * @throws SystemException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     */
    public function executeComponent()
    {
        try {
            $this->beforeExecute();
            $this->prepareResult();
        } catch (SystemException $e) {
            ShowError($e->getMessage());
        }
        $this->includeComponentTemplate();
    }


    private function prepareResult()
    {
        $filter = [];
        $filter['=ID'] = $this->arParams['LAPTOP_ID'];
        $query = new Query(Laptop::getEntity());
        $query->setSelect(['*', 'MODEL_NAME' => 'MODEL.NAME', 'MODEL_CODE' => 'MODEL.CODE', 'MANUFACTURER' => 'MODEL.MANUFACTURER.NAME']);
        $query->setFilter($filter);
        $result = $query->exec();
        if($result) {
            $this->arResult = $result->fetch();
        }

        if (empty($this->arResult)) {
            \Bitrix\Iblock\Component\Tools::process404(
                'Элемент не найден',
                true,
                true
            );
        }
    }
    private function beforeExecute(): void
    {
        Loader::includeModule('crm');
        if(!Loader::includeModule('lapshop'))
            throw new SystemException("Модуль Lapshop не установлен");
    }
}
