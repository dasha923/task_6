<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>
<div class="news-list">
    <ul>
        <?php foreach($arResult["ITEMS"] as $iblockGroup): ?>
            <?php if(!empty($iblockGroup['ITEMS'])): ?>
                <?php foreach($iblockGroup['ITEMS'] as $arItem): ?>
                    <?php 
                        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                    ?>
                    <li id="<?= $this->GetEditAreaId($arItem['ID']) ?>">
                        <?= $arItem['NAME'] ?>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
</div>