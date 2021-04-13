<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();


// debug($arResult["ELEM"]);


// в основной массив заполняем поле ELEM массивом в котором ключами будут айдишники разделов, а значениями массивы элементов / Использовать для вывода элементов внутри своих родительских разделов
foreach($arResult['ITEMS'] as $item){
  $sect = $item['IBLOCK_SECTION_ID'];
  $arResult['ELEM'][$sect][] = $item;
}

// $arSelect = Array("ID", "IBLOCK_ID",  "NAME",  'PREVIEW_TEXT', 'IBLOCK_SECTION_ID', 'DELETE_LINK', 'EDIT_LINK');
// $arFilter = Array("IBLOCK_TYPE"=>$arParams['IBLOCK_TYPE']);
// $res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false, $arSelect);

// // добавление айдишников секций в массив элементов 
// while($ob = $res->GetNextElement())
// {
// $arFields = $ob->GetFields();
// $section = $arFields['IBLOCK_SECTION_ID'];

// $arResult['ELEM'][$section][] = $arFields;
// }


?>