<?php
namespace Xypw\Lapshop;

use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\TextField;
use Bitrix\Main\Entity\ReferenceField;
use Bitrix\Main\Entity\ExpressionField;
use Bitrix\Main\SystemException;
use Bitrix\Main\Entity\EventResult;
use Bitrix\Main\Entity\Event;

class Model extends ModelTable {

}
class ModelTable extends DataManager
{
    /**
     * Returns DB table name for entity.
     *
     * @return string
     * @throws SystemException
     */
    public static function getTableName()
    {
        return 'xyp_model';
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
            new IntegerField(
                'MANUFACTURER_ID',
            ),
            new ReferenceField(
                'MANUFACTURER',
                '\Xypw\Lapshop\Manufacturer',
                ['=this.MANUFACTURER_ID' => 'ref.ID'],
                ['join_type' => 'INNER']
            ),
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
            $result->modifyFields($fields);
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
