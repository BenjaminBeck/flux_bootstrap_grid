<?php
namespace BDM\FluxBootstrapGrid\ViewHelpers\Bootstrap;
/*
 * This file is part of the FluidTYPO3/Vhs project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use BDM\FluxBootstrapGrid\Service\Bootstrap\Grid;
use FluidTYPO3\Vhs\Traits\TemplateVariableViewHelperTrait;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Creates chunks from an input Array/Traversable with option to allocate items to a fixed number of chunks
 *
 * @author Benjamin Rau <rau@codearts.at>, codearts
 * @package Vhs
 * @subpackage ViewHelpers\Iterator
 */
class GridViewHelper extends AbstractViewHelper {




	use TemplateVariableViewHelperTrait;

	/**
	 * @return void
	 */
	public function initializeArguments() {
		$this->registerAsArgument();
		$this->registerArgument('settings', 'mixed', 'The grid settings', FALSE, NULL);
	}

	/**
	 * Render method
	 *
	 * @throws \Exception
	 * @return array
	 */
	public function render() {
    	$settings = $this->arguments['settings'];
		if($settings==null){
			return $this->renderChildrenWithVariableOrReturnInput(false);
		}
		$this->settings = $settings;
		$this->rowCount = (int) $settings['rowCount'];
		if($this->rowCount==0){ // fallback for old data
			$this->rowCount = 1;
		}
		$this->colCount = (int) $settings['columnCount'];

		if($this->rowCount<1 || $this->colCount<1){
			return $this->renderChildrenWithVariableOrReturnInput(false);
			 throw new \TYPO3\CMS\Fluid\Core\ViewHelper\Exception('Grid settings invalid.', 6953036401);
		}
		$gridData = [];
		$grid = Grid::createInstanceFromSettings($settings);
		return $this->renderChildrenWithVariableOrReturnInput($grid);
	}


	private function getFrontendData (){
		$frontendData = [];
		for($row=1;$row<=$this->rowCount;$row++){
			for($col=1;$col<=$this->colCount;$col++){
				$colData = $this->getFrontendColumnData($row,$col);
				$frontendData['grid']['rows'][$row]['columns'][$col] = $colData;
			}
		}
		return $frontendData;
	}

	private function hasEqualWidthColumns(){
		return ($this->arguments['settings']['equalwidth'] == 1);
	}

	private function getBackendColumnWidth($col){
		if($this->hasEqualWidthColumns()){
			return (12 / $this->colCount);
		}
		$columnClassSettings = $this->arguments['settings']['columns'][$col]['class'];
		if($columnClassSettings['lg']){
			return (int) $columnClassSettings['lg'];
		}
		if($columnClassSettings['md']){
			return (int) $columnClassSettings['md'];
		}
		if($columnClassSettings['sm']){
			return (int) $columnClassSettings['sm'];
		}
		if($columnClassSettings['xs']){
			return (int) $columnClassSettings['xs'];
		}
		return (12 / $this->colCount);
	}

	private function getBackendData (){
		$backendData = [];
		if($this->hasEqualWidthColumns()){
			$sheetData = $this->getBackendSheetData(1);
			$sheetData['name'] = 'columnSettings1';
			$sheetData['label'] = 'Konfiguration';
			$backendData['sheets'][] = $sheetData;
		}else{
			for($col=1;$col<=$this->colCount;$col++){
				$sheetData = $this->getBackendSheetData($col);
				$sheetData['name'] = "columnSettings{$col}";
				$sheetData['label'] = "Column {$col}";
				$backendData['sheets'][$col] = $sheetData;
			}
		}
		$backendData['grid'] = [];
		for($row=1;$row<=$this->rowCount;$row++){
			for($col=1;$col<=$this->colCount;$col++){

				$gridColumnName = "column{$row}_{$col}";
				if($row==1){
					// backward compatibility
					$gridColumnName = "column".($col-1);
				}

				$gridColumnLabel = "Spalte {$col}";
				if($this->rowCount > 1){
					$gridColumnLabel = "Zeile {$row} / ".$gridColumnLabel;
				}

				$columns = $this->getBackendColumnWidth($col);
				$widthInPc = $columns / 12 * 100;

				$gridColumnStyle = "width: {$widthInPc}%;";
				if($col<$this->colCount){
					$gridColumnStyle .= "border-right: dashed grey 1px;";
				}
				if($row<$this->rowCount){
					$gridColumnStyle .= "border-bottom: dashed grey 1px;";
				}

				$colData = [
					'name' => $gridColumnName,
					'label' => $gridColumnLabel,
					'style' => $gridColumnStyle
				];
				$backendData['grid']['rows'][$row]['columns'][$col] = $colData;
			}
		}
		return $backendData;
	}
	private function getBackendSheetData($column){
		$column = (int) $column;
		$sheetData = [];
		$columnWidthSelectOptions = [
			["--",0],
			["1/12",1],
			["2/12",2],
			["3/12",3],
			["4/12",4],
			["5/12",5],
			["6/12",6],
			["7/12",7],
			["8/12",8],
			["9/12",9],
			["10/12",10],
			["11/12",11],
			["12/12",12]
		];

		$sheetData['selectFields']['xs']['options'] = $columnWidthSelectOptions;
		$sheetData['selectFields']['xs']['name'] = "settings.columns.{$column}.class.xs";
		$sheetData['selectFields']['xs']['label'] = "Extra small devices | Phones (<768px)";

		$sheetData['selectFields']['sm']['options'] = $columnWidthSelectOptions;
		$sheetData['selectFields']['sm']['name'] = "settings.columns.{$column}.class.sm";
		$sheetData['selectFields']['sm']['label'] = "Small devices | Tablets (≥768px)";

		$sheetData['selectFields']['md']['options'] = $columnWidthSelectOptions;
		$sheetData['selectFields']['md']['name'] = "settings.columns.{$column}.class.md";
		$sheetData['selectFields']['md']['label'] = "Medium devices | Desktops (≥992px)";

		$sheetData['selectFields']['lg']['options'] = $columnWidthSelectOptions;
		$sheetData['selectFields']['lg']['name'] = "settings.columns.{$column}.class.lg";
		$sheetData['selectFields']['lg']['label'] = "Large devices | Desktops (≥1200px)";

		$sheetData['selectFields']['lg']['default'] = $this->getBackendColumnWidth($column);


		$sheetData['inputFields']['label']['name'] = "settings.columns.{$column}.label";
		$sheetData['inputFields']['label']['label'] = "Backend-Preview: Column Label";
		$sheetData['inputFields']['label']['default'] = "Column {$column}";

		$sheetData['inputFields']['class']['name'] = "settings.columns.{$column}.class.additional";
		$sheetData['inputFields']['class']['label'] = "Frontend: Additional CSS Classes";

		$sheetData['inputFields']['backgroundColor']['name'] = "settings.columns.{$column}.backgroundColor";
		$sheetData['inputFields']['backgroundColor']['label'] = "Hintergrund Farbe (backend)";

		return $sheetData;
	}

	private function getFrontendColumnData($row=1,$col=1){
		$settings = $this->arguments['settings'];
		$columnSettings = $settings['columns'][$col];

		$columnData = [];

		$columnCssClasses = $this->getColumnCssClasses(
			$columnSettings['class']['xs'],
			$columnSettings['class']['sm'],
			$columnSettings['class']['md'],
			$columnSettings['class']['lg'],
			$columnSettings['class']['additional']
		);
		$columnData['cssClasses'] = $columnCssClasses;
		return $columnData;
	}

	private function getColumnCssClasses( $xs,$sm,$md,$lg, $additional){
		$xs = (int) $xs;
		$sm = (int) $sm;
		$md = (int) $md;
		$lg = (int) $lg;
		$cssClasses = [];
		if($xs > 0){
			$cssClasses[] = 'col-xs-'.$xs;
		}
		if($sm > 0){
			$cssClasses[] = 'col-sm-'.$sm;
		}
		if($md > 0){
			$cssClasses[] = 'col-md-'.$md;
		}
		if($lg > 0){
			$cssClasses[] = 'col-lg-'.$lg;
		}
		if(!empty($additional)){
			$cssClasses = array_merge($cssClasses,explode(' ', $additional));
		}
		return $cssClasses;
	}

}
