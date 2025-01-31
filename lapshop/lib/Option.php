<?php
namespace Xypw\Lapshop;

use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\TextField;
use Bitrix\Main\Entity\ReferenceField;
use Bitrix\Main\SystemException;

class Option extends OptionTable {

}
class OptionTable extends DataManager
{
    /**
     * Returns DB table name for entity.
     *
     * @return string
     * @throws SystemException
     */
    public static function getTableName()
    {
        return 'xyp_option';
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
            new TextField(
                'VALUE',
                [
                    'required' => true,
                ]
            ),
        ];
    }
}
