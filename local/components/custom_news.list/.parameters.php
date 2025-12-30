<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$arComponentParameters = [
    "PARAMETERS" => [
        "IBLOCK_TYPE" => [
            "NAME" => GetMessage("T_IBLOCK_DESC_LIST_TYPE"),
            "TYPE" => "STRING",
            "DEFAULT" => "news",
        ],
        "IBLOCK_ID" => [
            "NAME" => GetMessage("T_IBLOCK_DESC_LIST_ID"),
            "TYPE" => "STRING",
            "DEFAULT" => "",
        ],
        "NEWS_COUNT" => [
            "NAME" => "Количество элементов",
            "TYPE" => "STRING",
            "DEFAULT" => "20",
        ],
        "FIELD_CODE" => [
            "NAME" => GetMessage("IBLOCK_FIELD"),
            "TYPE" => "STRING",
            "DEFAULT" => "",
        ],
        "PROPERTY_CODE" => [
            "NAME" => GetMessage("T_IBLOCK_PROPERTY"),
            "TYPE" => "STRING",
            "DEFAULT" => "",
        ],
        "FILTER" => [
            "NAME" => GetMessage("T_IBLOCK_FILTER"),
            "TYPE" => "STRING",
            "DEFAULT" => "",
            "ROWS" => 5,
        ],
        "CACHE_TIME" => ["DEFAULT" => 3600],
    ],
];

?>