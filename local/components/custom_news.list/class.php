<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

class NewComponent extends CBitrixComponent
{

protected function getIblockIds()
{
$iblockIds = [];
	if(!empty($this->arParams['IBLOCK_ID'])){
        return [(int)$this->arParams['IBLOCK_ID']];
}

	$dbIblocks = CIBlock::GetList(
		['SORT'=>'ASC'],
        ['TYPE'=>$this->arParams['IBLOCK_TYPE'],'ACTIVE'=>'Y']
);
	while($iblock = $dbIblocks->Fetch()) {
        $iblockIds[] = (int)$iblock['ID'];
}
     return $iblockIds;
}

protected function getElements($iblockIds)
{
$result = [];
	if(empty($iblockIds)){
         return $result;
	}
$filter = ['IBLOCK_ID'=>$iblockIds,
'ACTIVE'=>'Y'
];

	if(!empty($this->arParams['FILTER'])&& is_array($this->arParams['FILTER'])){
        $filter = array_merge($filter, $this->arParams['FILTER']);
}
$select = ['ID', 'IBLOCK_ID', 'NAME', 'ACTIVE_FROM', 'DETAIL_PAGE_URL', 'PREVIEW_TEXT'];
	 if(!empty($this->arParams['FIELD_CODE'])){
            if(!is_array($this->arParams['FIELD_CODE'])){
                $fieldCodes = explode(',', $this->arParams['FIELD_CODE']);
                $fieldCodes = array_map('trim', $fieldCodes);
                $fieldCodes = array_filter($fieldCodes);
                $select = array_merge($select, $fieldCodes);
            } else {
                $select = array_merge($select, $this->arParams['FIELD_CODE']);
            }
        }
$dbItems = CIBlockElement::GetList(
            [$this->arParams['SORT_BY1'] => $this->arParams['SORT_ORDER1']],
            $filter,
            false,
            ['nTopCount' => $this->arParams['NEWS_COUNT']],
            $select
        );
 if(!empty($this->arParams['PROPERTY_CODE'])){
        if(!is_array($this->arParams['PROPERTY_CODE'])){
            $propCodes = explode(',', $this->arParams['PROPERTY_CODE']);
            $propCodes = array_map('trim', $propCodes);
            $propCodes = array_filter($propCodes);
            $dbItems->SetPropertyCodes($propCodes);
        } else {
            $dbItems->SetPropertyCodes($this->arParams['PROPERTY_CODE']);
        }
    }

	while($item = $dbItems->Fetch()){
        $iblockId = (int)$item['IBLOCK_ID'];

if($item['ACTIVE_FROM']){
                $dateFormat = $this->arParams['ACTIVE_DATE_FORMAT'] ?? 'd.m.Y';
                $item['DISPLAY_ACTIVE_FROM'] = CIBlockFormatProperties::DateFormat(
                    $dateFormat,
                    MakeTimeStamp($item['ACTIVE_FROM'], CSite::GetDateFormat())
                );
 }


if (!isset($result[$iblockId])) {
                $result[$iblockId] = [
                    'IBLOCK_ID' => $iblockId,
                    'ITEMS' => []
                ];
            }

            $result[$iblockId]['ITEMS'][] = $item;
}
return $result;
}
public function  executeComponent()
{
	if (empty($this->arParams['IBLOCK_TYPE'])){
        ShowError('Не указан тип инфоблока');
            return;
}
$this->arParams['NEWS_COUNT'] = $this->arParams['NEWS_COUNT'] ?? 20;
$this->arParams['SORT_BY1'] = $this->arParams['SORT_BY1'] ?? 'ACTIVE_FROM';
$this->arParams['SORT_ORDER1'] = $this->arParams['SORT_ORDER1'] ?? 'DESC';
$this->arParams['CACHE_TIME'] = $this->arParams['CACHE_TIME'] ?? 3600;

if($this->startResultCache($this->arParams['CACHE_TIME'])){
$iblockIds = $this->getIblockIds();
	if(empty($iblockIds)){
        ShowError('Инфоблоки указанного типа не найдены');
       $this->abortResultCache();
            return;

}
$this->arResult['ITEMS'] = $this->getElements($iblockIds);
$this->includeComponentTemplate();

}
}
}
?>