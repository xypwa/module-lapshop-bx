<?php
namespace Xypw\Lapshop;

use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\BooleanField;
use Bitrix\Main\ORM\Fields\DatetimeField;
use Bitrix\Main\ORM\Fields\EnumField;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\TextField;
use Bitrix\Main\Entity\ExpressionField;
use Bitrix\Main\SystemException;
use Bitrix\Main\Entity\Event;
use Bitrix\Main\Entity\EventResult;



class Manufacturer extends ManufacturerTable {

}
class ManufacturerTable extends DataManager
{
    /**
     * Returns DB table name for entity.
     *
     * @return string
     * @throws SystemException
     */
    public static function getTableName()
    {
        return 'xyp_manufacturer';
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
            new TextField('CODE'),
        ];
    }

    public static function prepareCode($value)
    {
        return mb_strtolower(\CUtil::translit(
                $value,
                'en',
                [
                    'replace_space' => '_',
                    'replace_other' => '',
                ]
            )).'_'.random_int(0, 1000);
    }

    public static function onBeforeAdd(Event $event)
    {
        $result = new EventResult();
        $fields = $event->getParameter('fields');

        if (isset($fields['NAME'])) {
            $fields['CODE'] = self::prepareCode($fields['NAME']);
            $result->modifyFields(['CODE' => $fields['CODE']]);
//            if($result->getErrors())
//                foreach ($result->getErrors() as $err)
//                    file_put_contents('/home/bitrix/www/bitrix/modules/error.log', print_r($err->getMessage(), true), 8);

        }



        return $result;
    }

    public static function onBeforeUpdate(Event $event)
    {
        $result = new EventResult();
        $fields = $event->getParameter('fields');

        if (isset($fields['NAME'])) {
            $fields['CODE'] = self::prepareCode($fields['NAME']);
            $result->modifyFields($fields);
        }

        return $result;
    }
}