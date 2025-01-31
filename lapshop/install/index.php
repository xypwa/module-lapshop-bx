<?php

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Application;
use Bitrix\Main\IO\Directory;
use Bitrix\Main\Entity\Base;

Loc::loadMessages(__FILE__);

class Lapshop extends CModule
{
    public $PARTNER_NAME = 'Подшивалов Евгений';
    public $MODULE_ID = 'lapshop';
    public $MODULE_NAME = 'Магазин ноутбуков';
    public $MODULE_VERSION;
    public $MODULE_VERSION_DATE;
    public $MODULE_DESCRIPTION = '';

    public  $SHOW_SUPER_ADMIN_GROUP_RIGHTS;
    public  $MODULE_GROUP_RIGHTS;
    private $path;
    private $errors;

    function __construct()
    {
        $arModuleVersion = array();

        $this->path = str_replace("\\", '/', __FILE__);
        $this->path = dirname($this->path);
        include($this->path . '/version.php');

        if (is_array($arModuleVersion) && array_key_exists('VERSION', $arModuleVersion)) {
            $this->MODULE_VERSION = $arModuleVersion['VERSION'];
            $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        }
        // если указано, то на странице прав доступа будут показаны администраторы и группы
        $this->SHOW_SUPER_ADMIN_GROUP_RIGHTS = 'Y';
        // если указано, то на странице редактирования групп будет отображаться этот модуль
        $this->MODULE_GROUP_RIGHTS = 'Y';
    }

    function InstallFiles()
    {
//        CopyDirFiles(
//            __DIR__ . '/admin',
//            $_SERVER['DOCUMENT_ROOT'] . '/bitrix/admin',
//            true,
//            true
//        );

        CopyDirFiles(
            __DIR__ . '/components',
            $_SERVER['DOCUMENT_ROOT'] . '/local/components',
            true,
            true
        );

        return true;
    }

    function UninstallFiles()
    {
        if(is_dir(Application::getDocumentRoot() . '/local/components/xypw')) {
            Directory::deleteDirectory(
                Application::getDocumentRoot() . '/local/components/xypw'
            );
        }
    }

    function DoInstall()
    {
        $context = Application::getInstance()->getContext();
        $request = $context->getRequest();
        global $APPLICATION;


        if ($this->errors) {
            var_dump($this->errors);
            die;
        }
        $step = (int) $request['step'];
        if ($step < 2) {
            $APPLICATION->IncludeAdminFile(
                Loc::getMessage('DB_REINSTALL_FORM_TITLE'),
                __DIR__ . '/instalInfo-step1.php'
            );
        }

        if($request['step'] == 2) {
            if($request['REINSTALL_DB'] === 'Y')
                $this->UnInstallDB();

//            die;
            $this->InstallDB();


            $this->InstallFiles();
            $this->InstallEvents();
//            $this->InstallAgents();
            ModuleManager::RegisterModule($this->MODULE_ID);
            $APPLICATION->includeAdminFile(
                Loc::getMessage('INSTALL_TITLE'),
                __DIR__ . '/instalInfo-step2.php'
            );
        }
    }

    function DoUninstall()
    {
        global $APPLICATION;
        $this->UnInstallDB();
        $this->UnInstallFiles();
        $this->UnInstallEvents();
//        $this->UninstallAgents();

        if ($this->errors) {
            var_dump($this->errors);
            die;
        }
        ModuleManager::UnRegisterModule($this->MODULE_ID);

        $APPLICATION->includeAdminFile(
            Loc::getMessage('DEINSTALL_TITLE'),
            __DIR__ . '/deInstalInfo.php'
        );
        return true;
    }

    function InstallDB()
    {
        global $DB;
        $this->errors = false;
        $this->errors = $DB->RunSQLBatch(
            $_SERVER['DOCUMENT_ROOT'] . '/local/modules/lapshop/install/db/install.sql'
        );

        if ($this->errors !== false) {
            $GLOBALS['APPLICATION']->ThrowException(implode('<br>', $this->errors));
            return false;
        }
        return true;
    }

    function UnInstallDB()
    {
        global $DB;
        $this->errors = false;
        $this->errors = $DB->RunSQLBatch(
            $_SERVER['DOCUMENT_ROOT'] . '/local/modules/lapshop/install/db/uninstall.sql'
        );

        if ($this->errors !== false) {
            $GLOBALS['APPLICATION']->ThrowException(implode('<br>', $this->errors));
            return false;
        }
        return true;
    }

    function InstallEvents()
    {
        RegisterModuleDependences('crm', 'onEntityDetailsTabsInitialized', $this->MODULE_ID, '\\Xypw\\Lapshop\\Main', 'addTabToDeal');
//        RegisterModuleDependences('main', 'OnAfterRegisterModule', $this->MODULE_ID, '\\Xypw\\Lapshop\\Main', 'fillDumbData');

        return true;
    }

    function InstallAgents()
    {
//        CAgent::AddAgent(
//            '\\Cwr\\Watrix\\SendQueueManager::checkQueues();',
//            $this->MODULE_ID,
//            'N',
//            300
//        );
        return true;
    }

    function UninstallAgents()
    {
        \CAgent::RemoveModuleAgents($this->MODULE_ID);
        return true;
    }

    function UnInstallEvents()
    {
        UnRegisterModuleDependences('crm', 'onEntityDetailsTabsInitialized', $this->MODULE_ID, '\\Xypw\\Lapshop\\Main', 'addTabToDeal');
//        UnRegisterModuleDependences('main', 'OnAfterRegisterModule', $this->MODULE_ID, '\\Xypw\\Lapshop\\Main', 'fillDumbData');
        return true;
    }

    function fillDumbData() {
        Loader::includeModule($this->MODULE_ID);
        \Xypw\Lapshop\Manufacturer::add([
            'NAME' => 'Lenove',
        ]);
    }

}
