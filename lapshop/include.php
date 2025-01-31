<?php
Bitrix\Main\Loader::registerAutoloadClasses(
// имя модуля
    "lapshop",
    array(
        // ключ - имя класса с простанством имен, значение - путь относительно корня сайта к файлу
        "Xypw\\Lapshop\\Main" => "lib/Main.php",

        "Xypw\\Lapshop\\Laptop" => "lib/Laptop.php",
//        "Xypw\\Lapshop\\LaptopTable" => "lib/Laptop.php",

        "Xypw\\Lapshop\\Model" => "lib/Model.php",
//        "Xypw\\Lapshop\\ModelTable" => "lib/Model.php",

        "Xypw\\Lapshop\\Manufacturer" => "lib/Manufacturer.php",
//        "Xypw\\Lapshop\\ManufacturerTable" => "lib/Manufacturer.php",

        "Xypw\\Lapshop\\Option" => "lib/Option.php",
//        "Xypw\\Lapshop\\OptionTable" => "lib/Option.php",

        "Xypw\\Lapshop\\LaptopOption" => "lib/LaptopOption.php",
//        "Xypw\\Lapshop\\LaptopOptionTable" => "lib/LaptopOption.php",
    )
);


