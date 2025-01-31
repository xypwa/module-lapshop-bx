<?php
namespace Xypw\Lapshop;

use Bitrix\Main\Entity\FloatField;
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\DatetimeField;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\TextField;
use Bitrix\Main\Entity\ReferenceField;
use Bitrix\Main\SystemException;

class Laptop extends LaptopTable {

}
class LaptopTable extends DataManager
{
    /**
     * Returns DB table name for entity.
     *
     * @return string
     * @throws SystemException
     */
    public static function getTableName()
    {
        return 'xyp_laptop';
    }

    /**
     * Returns entity map definition.
     *
     * @return array
     */
    public static function getMap()
    {
        return [
            new IntegerField(
                'ID',
                [
                    'primary' => true,
                    'autocomplete' => true
                ]
            ),
            new TextField(
                'NAME',
                [
                    'required' => true,
                ]
            ),
            new IntegerField(
                'YEAR',
                [
                    'required' => true,
                ]
            ),
            new FloatField(
                'PRICE',
                [
                    'required' => true,
                    'default_value' => 0,
                ]
            ),
            new IntegerField(
                'MODEL_ID',
            ),
            new ReferenceField(
                'MODEL',
                '\Xypw\Lapshop\Model',
                ['=this.MODEL_ID' => 'ref.ID'],
                ['join_type' => 'INNER']
            ),
        ];
    }
}
