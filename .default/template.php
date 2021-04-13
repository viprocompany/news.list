<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

// function debug($data){
// 	echo '<pre>'.print_r ($data,1).'<pre>';
// }
// debug($arResult);
?>
<style type="text/css">
	.hide {
		display: none;
	}

	.show {
		display: block;
	}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<div class="test">
	<div class="container ">
		<div class="row">
			<? //вызов  категорий?>
			<div class="links col-lg-4">
				<?
				// debug($arResult["ITEMS"]);
							//для получения имени раздела (категории)	
					$rs_Section = CIBlockSection::GetList(array('left_margin' => 'asc'), array("IBLOCK_ID"=>$arResult['ID']));
					// собираем массив того, что нам нужно
					while ( $ar_Section = $rs_Section->Fetch() ) {				
						$ar_Sections[] = array(  
					'ID' => $ar_Section['ID'], 
					'NAME' => $ar_Section['NAME'],
					'IBLOCK_SECTION_ID' => $ar_Section['IBLOCK_SECTION_ID'],
					'DEPTH_LEVEL' => $ar_Section['DEPTH_LEVEL'],				
						); 
					}	
								?>
				<? // ссылки на разделы?>
				<ul class="links">
					<li>
						<a class="all" href="#">
							<h2>Показать всё</h2>
						</a>
					</li>
					<?
   				foreach ($ar_Sections as $key => $section) {  
								 	// создаем класс для раздела, кликнув по которому  задаем активность  элементам этого раздела( путем создания айдишника оболочки элементов раздела. К #test- добавляем значение класса  раздела $section['ID'](получаем из ключа массива $arResult['ELEM'], который является $section['ID'])). Таким образом элементы раздела , заключены в оболочку с айдишником #test-$section['ID'], которая по клику на раздел получает класс видимости show, а оболочки элементов других разделов получают класс hide, при котором становятся скрытыми.
					 $class = "";					  					
					 $class = $section['ID'];

						// создаем переменную $size  с заданием размера заголовка в зависимости от вложенности раздела	с добавлением к ней значения переменной $plus. Врезультате от вложенности получаем теги: H4, H5, H6 для названий разделов					
						$plus = 3;
						$size = $section['DEPTH_LEVEL'] + $plus ;

						// считаем количество элементов в разделе
						$rsSection = CIBlockSection::GetList(array(), array('ID' => $section['ID'], 'ELEMENT_SUBSECTIONS' => 'N'), true, array());
						if ($arSection = $rsSection->GetNext()) {
							// echo $arSection['ELEMENT_CNT'];
						}
   					?>
					<li id="<?=$this->GetEditAreaId($section['ID']);?>">
						<a class="<?=$class;?>" href="#test-<?=$section['ID']?>">
							<h<?=$size;?>><?=$section['NAME'];?>(элементов <?=$arSection['ELEMENT_CNT'];?>)</h<?=$size;?>>
						</a>
						<?								
								echo 	 "<script>
									$('." . $section['ID']  . "').on('click', function () {
										$('.test-item').removeClass('show');
										$('.test-item').addClass('hide');
										$('#test-" .  $section['ID'] . "').addClass('show');
									});
								</script>";
								?>
					</li>
					<?
   					}
   					?>
				</ul>
			</div>
			<? //вызов элементов категорий?>
			<div class="items col-lg-8 ">

				<? // получаем оболочки разделов для размещения элементов из массива $arResult['ELEM'], созданного в result.modifier 
				// debug($arResult);
				?>
				<?foreach($arResult['ELEM'] as $key => $section){?>
				<div id="<?=$this->GetEditAreaId($section['ID']);?>">
					<ul id="test-<?=$key?>" class="test-item ">
						<? // получаем элементы раздела?>
						<? foreach($section as $key => $element)  {?>
						<? 
							$this->AddEditAction($element['ID'], $element['EDIT_LINK'], CIBlock::GetArrayByID($element["IBLOCK_ID"], "ELEMENT_EDIT"));
							$this->AddDeleteAction($element['ID'], $element['DELETE_LINK'], CIBlock::GetArrayByID($element["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
				  	?>
						<li class="item" id="<?=$this->GetEditAreaId($element['ID']);?>">
							<a href="<?=$element['DETAIL_PAGE_URL']?>">
								<p class="name"><?=$element['NAME']?></p>
							</a>
							<div class="text">
								<p><?=$element['PREVIEW_TEXT']?></p>
							</div>
						</li>
						<?}?>
					</ul>
				</div>
				<?}?>
			</div>
		</div>
	</div>
</div>
<? //этим скриптом даем видимость всем элементам страницы при клике на ссылку "Показать всё" ?>
<script>
	$('.all').on('click', function () {
		$('.test-item').removeClass('hide');
		$('.test-item').addClass('show');
	});
</script>