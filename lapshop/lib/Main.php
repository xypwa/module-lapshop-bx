<?php
// пространство имен для класса Test
namespace Xypw\Lapshop;

use Bitrix\Main\ArgumentNullException;
use Bitrix\Main\Result;
use Bitrix\Main\Error;
use Bitrix\Main\Type\DateTime;
use Bitrix\Main\UserTable;
use Bitrix\Main\Event;

use Xypw\Lapshop\Laptop;
use Xypw\Lapshop\LaptopOption;
use Xypw\Lapshop\Option;
use Xypw\Lapshop\Model;
use Xypw\Lapshop\Manufacturer;
use Xypw\Lapshop\Service\Debug;

\Bitrix\Main\Loader::includeModule('crm');
class Main
{
//    public Laptop $instancesService;

    public function __construct()
    {
        $this->debugService = new Service\Debug();
    }

    static function fillDumbData() {
        $M_1 = Manufacturer::add(['NAME' => 'Lebova']);
        $M_2 = Manufacturer::add(['NAME' => 'AZUS']);
        $M_3 = Manufacturer::add(['NAME' => 'Apper']);
        $M_4 = Manufacturer::add(['NAME' => 'Inter']);

        $R2_1 = Model::add(['NAME' => 'LS-50', 'MANUFACTURER_ID' => $M_1->getId()]);
        $R2_2 = Model::add(['NAME' => 'LS-150', 'MANUFACTURER_ID' => $M_1->getId()]);
        $R2_3 = Model::add(['NAME' => 'AZ-11', 'MANUFACTURER_ID' => $M_2->getId()]);
        $R2_4 = Model::add(['NAME' => 'AZ-12', 'MANUFACTURER_ID' => $M_2->getId()]);
        $R2_5 = Model::add(['NAME' => 'AZ-13', 'MANUFACTURER_ID' => $M_2->getId()]);
        $R2_6 = Model::add(['NAME' => 'Air1', 'MANUFACTURER_ID' => $M_3->getId()]);
        $R2_7 = Model::add(['NAME' => 'Pro', 'MANUFACTURER_ID' => $M_3->getId()]);
        $R2_8 = Model::add(['NAME' => 'RR', 'MANUFACTURER_ID' => $M_4->getId()]);
        $R2_9 = Model::add(['NAME' => 'BB', 'MANUFACTURER_ID' => $M_4->getId()]);
        $R2_10 = Model::add(['NAME' => 'PP', 'MANUFACTURER_ID' => $M_4->getId()]);

        $L1 = Laptop::add([
            'NAME' => 'Hunter-XC'." ".$R2_1->getObject()->get('NAME'),
            'MODEL' => $R2_1->getObject(),
            'MODEL_ID' => $R2_1->getId(),
            'YEAR' => (\Bitrix\Main\Type\DateTime::createFromText("10.01.2017"))->format('Y'),
            'PRICE' => 700,
        ]);
        $L2 = Laptop::add([
            'NAME' => 'Hunter-3DC' . ' ' . $R2_2->getObject()->get('NAME'),
            'MODEL' => $R2_2->getObject(),
            'MODEL_ID' => $R2_2->getId(),
            'YEAR' => \Bitrix\Main\Type\DateTime::createFromText('01.10.2019')->format('Y'),
            'PRICE' => 850,
        ]);
        $L2_1 = Laptop::add([
            'NAME' => 'Hunter-3DC' . ' ' . $R2_2->getObject()->get('NAME'),
            'MODEL' => $R2_2->getObject(),
            'MODEL_ID' => $R2_2->getId(),
            'YEAR' => \Bitrix\Main\Type\DateTime::createFromText('01.10.2024')->format('Y'),
            'PRICE' => 1250,
        ]);

        $L3 = Laptop::add([
            'NAME' => 'GG-C' . ' ' . $R2_3->getObject()->get('NAME'),
            'MODEL' => $R2_3->getObject(),
            'MODEL_ID' => $R2_3->getId(),
            'YEAR' => \Bitrix\Main\Type\DateTime::createFromText('10.10.2021')->format('Y'),
            'PRICE' => 680,
        ]);

        $L4 = Laptop::add([
            'NAME' => 'ZBC-Wipe' . ' ' . $R2_4->getObject()->get('NAME'),
            'MODEL' => $R2_4->getObject(),
            'MODEL_ID' => $R2_4->getId(),
            'YEAR' => \Bitrix\Main\Type\DateTime::createFromText('10.01.2022')->format('Y'),
            'PRICE' => 900,
        ]);
        $L4_1 = Laptop::add([
            'NAME' => 'ZBC-Wipe' . ' ' . $R2_4->getObject()->get('NAME'),
            'MODEL' => $R2_4->getObject(),
            'MODEL_ID' => $R2_4->getId(),
            'YEAR' => \Bitrix\Main\Type\DateTime::createFromText('10.01.2023')->format('Y'),
            'PRICE' => 1000,
        ]);
        $L4_2 = Laptop::add([
            'NAME' => 'ZBC-Wipe' . ' ' . $R2_4->getObject()->get('NAME'),
            'MODEL' => $R2_4->getObject(),
            'MODEL_ID' => $R2_4->getId(),
            'YEAR' => \Bitrix\Main\Type\DateTime::createFromText('10.01.2022')->format('Y'),
            'PRICE' => 1150,
        ]);
        $L4_3 = Laptop::add([
            'NAME' => 'ZBC-Wipe' . ' ' . $R2_4->getObject()->get('NAME'),
            'MODEL' => $R2_4->getObject(),
            'MODEL_ID' => $R2_4->getId(),
            'YEAR' => \Bitrix\Main\Type\DateTime::createFromText('10.11.2022')->format('Y'),
            'PRICE' => 1050,
        ]);
        $L4_4 = Laptop::add([
            'NAME' => 'ZBC-Wipe' . ' ' . $R2_4->getObject()->get('NAME'),
            'MODEL' => $R2_4->getObject(),
            'MODEL_ID' => $R2_4->getId(),
            'YEAR' => \Bitrix\Main\Type\DateTime::createFromText('10.01.2023')->format('Y'),
            'PRICE' => 1450,
        ]);
        $L4_5 = Laptop::add([
            'NAME' => 'ZBC-Wipe' . ' ' . $R2_4->getObject()->get('NAME'),
            'MODEL' => $R2_4->getObject(),
            'MODEL_ID' => $R2_4->getId(),
            'YEAR' => \Bitrix\Main\Type\DateTime::createFromText('10.01.2020')->format('Y'),
            'PRICE' => 1350,
        ]);
        $L4_6 = Laptop::add([
            'NAME' => 'ZBC-Wipe' . ' ' . $R2_4->getObject()->get('NAME'),
            'MODEL' => $R2_4->getObject(),
            'MODEL_ID' => $R2_4->getId(),
            'YEAR' => \Bitrix\Main\Type\DateTime::createFromText('10.01.2022')->format('Y'),
            'PRICE' => 1150,
        ]);
        $L4_7 = Laptop::add([
            'NAME' => 'ZBC-Wipe' . ' ' . $R2_4->getObject()->get('NAME'),
            'MODEL' => $R2_4->getObject(),
            'MODEL_ID' => $R2_4->getId(),
            'YEAR' => \Bitrix\Main\Type\DateTime::createFromText('10.01.2022')->format('Y'),
            'PRICE' => 1150,
        ]);

        $L5 = Laptop::add([
            'NAME' => 'Fury' . ' ' . $R2_5->getObject()->get('NAME'),
            'MODEL' => $R2_5->getObject(),
            'MODEL_ID' => $R2_5->getId(),
            'YEAR' => \Bitrix\Main\Type\DateTime::createFromText('01.01.2020')->format('Y'),
            'PRICE' => 700,
        ]);

        $L6 = Laptop::add([
            'NAME' => 'LazyC' . ' ' . $R2_6->getObject()->get('NAME'),
            'MODEL' => $R2_6->getObject(),
            'MODEL_ID' => $R2_6->getId(),
            'YEAR' => \Bitrix\Main\Type\DateTime::createFromText('01.10.2019')->format('Y'),
            'PRICE' => 1000,
        ]);

        $L7 = Laptop::add([
            'NAME' => 'Flexd' . ' ' . $R2_7->getObject()->get('NAME'),
            'MODEL' => $R2_7->getObject(),
            'MODEL_ID' => $R2_7->getId(),
            'YEAR' => \Bitrix\Main\Type\DateTime::createFromText('10.10.2023')->format('Y'),
            'PRICE' => 1400,
        ]);

        $L8 = Laptop::add([
            'NAME' => 'Trash-X' . ' ' . $R2_8->getObject()->get('NAME'),
            'MODEL' => $R2_8->getObject(),
            'MODEL_ID' => $R2_8->getId(),
            'YEAR' => \Bitrix\Main\Type\DateTime::createFromText('01.01.2023')->format('Y'),
            'PRICE' => 900,
        ]);
        $L8_1 = Laptop::add([
            'NAME' => 'Trash-X' . ' ' . $R2_8->getObject()->get('NAME'),
            'MODEL' => $R2_8->getObject(),
            'MODEL_ID' => $R2_8->getId(),
            'YEAR' => \Bitrix\Main\Type\DateTime::createFromText('10.01.2023')->format('Y'),
            'PRICE' => 950,
        ]);

        $L9 = Laptop::add([
            'NAME' => 'Sleep' . ' ' . $R2_9->getObject()->get('NAME'),
            'MODEL' => $R2_9->getObject(),
            'MODEL_ID' => $R2_9->getId(),
            'YEAR' => \Bitrix\Main\Type\DateTime::createFromText('10.01.2024')->format('Y'),
            'PRICE' => 1090,
        ]);

        $L10 = Laptop::add([
            'NAME' => 'Nerf-o' . ' ' . $R2_10->getObject()->get('NAME'),
            'MODEL' => $R2_10->getObject(),
            'MODEL_ID' => $R2_10->getId(),
            'YEAR' => \Bitrix\Main\Type\DateTime::createFromText('10.01.2018')->format('Y'),
            'PRICE' => 1700,
        ]);
        $L10_1 = Laptop::add([
            'NAME' => 'Nerf-o' . ' ' . $R2_10->getObject()->get('NAME'),
            'MODEL' => $R2_10->getObject(),
            'MODEL_ID' => $R2_10->getId(),
            'YEAR' => \Bitrix\Main\Type\DateTime::createFromText('10.01.2018')->format('Y'),
            'PRICE' => 1800,
        ]);

        $O1_1 = Option::add(['fields' => ['NAME' => 'Объем памяти', 'VALUE' => '16Гб' ]]);
        $O1_2 = Option::add(['fields' => ['NAME' => 'Объем памяти', 'VALUE' => '32Гб' ]]);
        $O2_1 = Option::add(['fields' => ['NAME' => 'Процессор', 'VALUE' => 'Intel']]);
        $O2_2 = Option::add(['fields' => ['NAME' => 'Процессор', 'VALUE' => 'Amd']]);

        LaptopOption::add(['LAPTOP_ID' => $L1->getId(), 'OPTION_ID' => $O1_1->getId()]);
        LaptopOption::add(['LAPTOP_ID' => $L1->getId(), 'OPTION_ID' => $O2_1->getId()]);

        LaptopOption::add(['LAPTOP_ID' => $L2->getId(), 'OPTION_ID' => $O1_1->getId()]);
        LaptopOption::add(['LAPTOP_ID' => $L2->getId(), 'OPTION_ID' => $O2_2->getId()]);

        LaptopOption::add(['LAPTOP_ID' => $L2_1->getId(), 'OPTION_ID' => $O1_2->getId()]);
        LaptopOption::add(['LAPTOP_ID' => $L2_1->getId(), 'OPTION_ID' => $O2_2->getId()]);

        LaptopOption::add(['LAPTOP_ID' => $L3->getId(), 'OPTION_ID' => $O1_2->getId()]);
        LaptopOption::add(['LAPTOP_ID' => $L3->getId(), 'OPTION_ID' => $O2_1->getId()]);

        LaptopOption::add(['LAPTOP_ID' => $L4->getId(), 'OPTION_ID' => $O1_1->getId()]);
        LaptopOption::add(['LAPTOP_ID' => $L4->getId(), 'OPTION_ID' => $O2_2->getId()]);

        LaptopOption::add(['LAPTOP_ID' => $L4_1->getId(), 'OPTION_ID' => $O1_1->getId()]);
        LaptopOption::add(['LAPTOP_ID' => $L4_1->getId(), 'OPTION_ID' => $O2_1->getId()]);

        LaptopOption::add(['LAPTOP_ID' => $L4_2->getId(), 'OPTION_ID' => $O1_2->getId()]);
        LaptopOption::add(['LAPTOP_ID' => $L4_2->getId(), 'OPTION_ID' => $O2_2->getId()]);

        LaptopOption::add(['LAPTOP_ID' => $L4_3->getId(), 'OPTION_ID' => $O1_2->getId()]);
        LaptopOption::add(['LAPTOP_ID' => $L4_3->getId(), 'OPTION_ID' => $O2_2->getId()]);

        LaptopOption::add(['LAPTOP_ID' => $L4_4->getId(), 'OPTION_ID' => $O1_1->getId()]);
        LaptopOption::add(['LAPTOP_ID' => $L4_4->getId(), 'OPTION_ID' => $O2_2->getId()]);

        LaptopOption::add(['LAPTOP_ID' => $L4_5->getId(), 'OPTION_ID' => $O1_1->getId()]);
        LaptopOption::add(['LAPTOP_ID' => $L4_5->getId(), 'OPTION_ID' => $O2_2->getId()]);


        LaptopOption::add(['LAPTOP_ID' => $L5->getId(), 'OPTION_ID' => $O1_1->getId()]);
        LaptopOption::add(['LAPTOP_ID' => $L5->getId(), 'OPTION_ID' => $O2_1->getId()]);

        LaptopOption::add(['LAPTOP_ID' => $L6->getId(), 'OPTION_ID' => $O1_2->getId()]);
        LaptopOption::add(['LAPTOP_ID' => $L6->getId(), 'OPTION_ID' => $O2_2->getId()]);

        LaptopOption::add(['LAPTOP_ID' => $L7->getId(), 'OPTION_ID' => $O1_1->getId()]);
        LaptopOption::add(['LAPTOP_ID' => $L7->getId(), 'OPTION_ID' => $O2_2->getId()]);

        LaptopOption::add(['LAPTOP_ID' => $L8->getId(), 'OPTION_ID' => $O1_1->getId()]);
        LaptopOption::add(['LAPTOP_ID' => $L8->getId(), 'OPTION_ID' => $O2_2->getId()]);

        LaptopOption::add(['LAPTOP_ID' => $L8_1->getId(), 'OPTION_ID' => $O1_1->getId()]);
        LaptopOption::add(['LAPTOP_ID' => $L8_1->getId(), 'OPTION_ID' => $O2_1->getId()]);

        LaptopOption::add(['LAPTOP_ID' => $L9->getId(), 'OPTION_ID' => $O1_1->getId()]);
        LaptopOption::add(['LAPTOP_ID' => $L9->getId(), 'OPTION_ID' => $O2_2->getId()]);

        LaptopOption::add(['LAPTOP_ID' => $L10->getId(), 'OPTION_ID' => $O1_1->getId()]);
        LaptopOption::add(['LAPTOP_ID' => $L10->getId(), 'OPTION_ID' => $O2_1->getId()]);

        LaptopOption::add(['LAPTOP_ID' => $L10_1->getId(), 'OPTION_ID' => $O1_1->getId()]);
        LaptopOption::add(['LAPTOP_ID' => $L10_1->getId(), 'OPTION_ID' => $O2_2->getId()]);

    }

    static function addTabToDeal($entityID, $entityTypeID, $guid, $tabs) {
//        file_put_contents("/home/bitrix/www/bitrix/modules/error.log", print_r($tabs, true), 8);
//        return new \Bitrix\Main\EventResult(\Bitrix\Main\EventResult::SUCCESS);
        if ($entityTypeID == \CCrmOwnerType::Deal) {
            array_push($tabs, [
                'id' => 'tab_lapshop_1',
                'name' => 'Ноуты',
                'enabled' => true,
                'loader' => [
                    'serviceUrl' => '/test/1.php',
                    'componentData' => [
                        'PLACEMENT' => $entityTypeID,
                        'PLACEMENT_OPTIONS' => [
                            'ID' => $entityID,
                        ],
                    ]
                ]
            ]);
        }

        return new \Bitrix\Main\EventResult(\Bitrix\Main\EventResult::SUCCESS, [
            'entityID' => $entityID, 'entityTypeID' => $entityTypeID, 'guid' => $guid, 'tabs' => $tabs
        ]);
    }
}

