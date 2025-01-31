<?php
namespace Xypw\Lapshop;

use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\TextField;
use Bitrix\Main\Entity\ReferenceField;
use Bitrix\Main\SystemException;

class LaptopOption extends LaptopOptionTable {

}
class LaptopOptionTable extends DataManager
{
    /**
     * Returns DB table name for entity.
     *
     * @return string
     * @throws SystemException
     */
    public static function getTableName()
    {
        return 'xyp_laptop_to_option';
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
                'LAPTOP_ID',
                [
                    'primary' => true,
                ]
            ),
            new ReferenceField(
                'LAPTOP',
                '\Xypw\Lapshop\Laptop',
                ['=this.LAPTOP_ID' => 'ref.ID'],
            ),
            new IntegerField(
                'OPTION_ID',
                [
                    'primary' => true,
                ]
            ),
            new ReferenceField(
                'OPTION',
                '\Xypw\Lapshop\Option',
                ['=this.OPTION_ID' => 'ref.ID'],
            ),
        ];
    }
}
