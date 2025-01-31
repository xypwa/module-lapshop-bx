<?php

use Bitrix\Main\ArgumentNullException;
use Bitrix\Main\ArgumentOutOfRangeException;
use Bitrix\Main\Loader;
use Bitrix\Main\LoaderException;
use Bitrix\Main\SystemException;
use Bitrix\Main\Application;
use Bitrix\Main\ORM\Fields\ExpressionField;
use Bitrix\Main\ORM\Query\Query;
use Xypw\Lapshop\Manufacturer;
use Xypw\Lapshop\Laptop;
use Xypw\Lapshop\Model;
use Bitrix\Main\Grid\Options as GridOptions;
use Bitrix\Main\UI\Filter\Options as FilterOptions;

class LapshopListComponent extends CBitrixComponent
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
            $page = $this->prepareData();
            $this->IncludeComponentTemplate($page);

        } catch (SystemException $e) {
            ShowError($e->getMessage());
        }
    }


    private function prepareData()
    {
        echo '<pre>';

        $filter = [];

        $sortOption = new GridOptions('laptop_grid');
        $sort = $sortOption->GetSorting(['sort' => ['ID' => 'ASC']]);
        $filterOption = new FilterOptions('laptop_filter');
        $grid_filter = $filterOption->getFilter(['PRICE', 'YEAR']);
//        file_put_contents('/home/bitrix/www/bitrix/modules/error.log', print_r($grid_filter, true), 8);
        if($grid_filter['PRICE_numsel']) {
            switch ($grid_filter['PRICE_numsel']) {
                case 'range':
                    if($grid_filter['PRICE_from'])
                        $filter['>=PRICE'] = $grid_filter['PRICE_from'];
                    if($grid_filter['PRICE_to'])
                        $filter['<=PRICE'] = $grid_filter['PRICE_to'];
                    break;
                case 'less':
                    $filter['<PRICE'] = $grid_filter['PRICE_to'];
                    break;
                case 'more':
                    $filter['>PRICE'] = $grid_filter['PRICE_from'];
                    break;
                case 'exact':
                    $filter['=PRICE'] = $grid_filter['PRICE_from'];
                    break;
            }
        }
        if($grid_filter['YEAR']) {
            $filter['=YEAR'] = $grid_filter['YEAR'];
        }
//        var_dump('Brand: ' . $this->arParams['BRAND']);
//        var_dump('Model: ' . $this->arParams['MODEL']);
        $page = 'brands';
        $pageSize = 5;
        $pageSizes = [];
        foreach ([5, 10] as $index)
        {
            $pageSizes[] = ['NAME' => $index, 'VALUE' => $index];
        }
        $nav = new \Bitrix\Main\UI\PageNavigation('lapshop');
        $nav->allowAllRecords(false)
            ->setPageSize($pageSize)
            ->setPageSizes($pageSizes)
            ->initFromUri();

        if ($this->arParams['BRAND'] || $this->arParams['MODEL']) {
            if ($this->arParams['BRAND']) {
                $filter['=MODEL.MANUFACTURER.CODE'] = $this->arParams['BRAND'];
            }

            if ($this->arParams['MODEL']) {
                $filter['=MODEL.CODE'] = $this->arParams['MODEL'];
            }

//            var_dump($filter);
            $query = new Query(Laptop::getEntity());
            $query->setSelect(['*', 'MODEL_NAME' => 'MODEL.NAME', 'MODEL_CODE' => 'MODEL.NAME', 'MANUFACTURER_CODE' => 'MODEL.MANUFACTURER.CODE',  'MANUFACTURER_ID' => 'MODEL.MANUFACTURER.ID', 'MANUFACTURER' => 'MODEL.MANUFACTURER.NAME']);
            $query->setFilter($filter);

            $query->setOffset($nav->getOffset());
            $query->setLimit($nav->getLimit());

            if($sort) {
                foreach ($sort['sort'] as $field => $direction) {
                    $query->addOrder($field, $direction);
                }
            }

            $cnt = Laptop::getCount($filter);
            $nav->setRecordCount($cnt);


            $result = $query->exec();

            while ($arItem = $result->fetch()) {
                $arItem['MANUFACTURER'] = "<a href='{$this->arParams['SEF_FOLDER']}{$arItem['MANUFACTURER_CODE']}/'>{$arItem['MANUFACTURER']}</a>";
                $arItem['MODEL_NAME'] = "<a href='{$this->arParams['SEF_FOLDER']}{$arItem['MANUFACTURER_CODE']}/{$arItem['MODEL_CODE']}/'>{$arItem['MODEL_NAME']}</a>";
                $arItem['NAME'] = "<a href='{$this->arParams['SEF_FOLDER']}{$arItem['MANUFACTURER_CODE']}/{$arItem['MODEL_CODE']}/{$arItem['ID']}/'>{$arItem['NAME']}</a>";
                $this->arResult['grid']['ROWS'][] = [
                    'id' => $arItem['ID'],
                    'columns' => $arItem,
                ];
            }
            $this->arResult['grid']['NAV_OBJECT'] = $nav;
            $page = 'items';

            $this->prepareFilterFields();


        } else {
            $result = Manufacturer::getList();
            while ($arItem = $result->fetch()) {
                $this->arResult[] = $arItem;
            }
        }

        echo '</pre>';
        return $page;
    }

    private function prepareFilterFields() {

        $years = [];
        $query = new Query(Laptop::getEntity());
        $query->setSelect(['YEAR']);
        $query->setDistinct(true);
        $query->setOrder(['YEAR' => 'DESC']);
        $res = $query->exec();
        while($row = $res->fetch())
            $years[$row['YEAR']] = $row['YEAR'];


        $manufacturers = [];
        $query = new Query(Manufacturer::getEntity());
        $query->setSelect(['ID', 'NAME']);
        $res = $query->exec();
        while($row = $res->fetch())
            $manufacturers[$row['ID']] = $row['NAME'];

        $models = [];
        $query = new Query(Model::getEntity());
        $query->setSelect(['ID', 'NAME']);
        $res = $query->exec();
        while($row = $res->fetch())
            $models[$row['ID']] = $row['NAME'];

        $this->arResult['filter_fields'] = [
            'RELEASE_YEAR' => $years,
            'BRAND' => $manufacturers,
            'MODEL' => $models
        ];

        $this->arResult['FILTER'] = [
            //    [
            //        'id' => 'BRAND',
            //        'name' => 'Бренд',
            //        'type' => 'string',
            //        'default' => true,
            //    ],
            //    [
            //        'id' => 'MODEL',
            //        'name' => 'Модель',
            //        'type' => 'string',
            //        'default' => true,
            //    ],
            [
                'id' => 'PRICE',
                'name' => 'Цена',
                'type' => 'number',
                'default' => true,
            ],
            [
                'id' => 'YEAR',
                'name' => 'Год выпуска',
                'type' => 'list',
                'items' => $years,
                'default' => true,
            ],
        ];
    }
    private function beforeExecute(): void
    {
        Loader::includeModule('crm');
        if (!Loader::includeModule('lapshop')) {
            throw new SystemException('Модуль Lapshop не установлен');
        }
    }
}
