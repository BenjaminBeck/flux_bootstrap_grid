<?php
namespace BDM\FluxBootstrapGrid\Service\Bootstrap;

/***************************************************************
 *  Copyright notice
 *  (c) 2016 Benjamin Beck <BenjaminBeck@gmx.de>, beck digitale medien
 *  All rights reserved
 *  Usage and modifiction only with permission!
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * @author  Benjamin Beck <beck@beck-digitale-medien.de>
 */
class Sheet {


	/**
	 * @return string
	 */
	public function getName () {
		return 'columnSettings'.$this->column->getPosition();
	}


	/**
	 * @return string
	 */
	public function getLabel () {
		if($this->getColumn()->getRow()->getGrid()->isEqualWidth()){
			return "Spalten Konfiguration";
		}
		return 'Spalte '.$this->column->getPosition();
	}


	/**
	 * @return array
	 */
	public function getSelectFields () {

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

		$selectFields['xs']['options'] = $columnWidthSelectOptions;
		$selectFields['xs']['name'] = "settings.columns.{$this->getColumn()->getIndex()}.class.xs";
		$selectFields['xs']['label'] = "Extra small devices | Phones (<768px)";

		$selectFields['sm']['options'] = $columnWidthSelectOptions;
		$selectFields['sm']['name'] = "settings.columns.{$this->getColumn()->getIndex()}.class.sm";
		$selectFields['sm']['label'] = "Small devices | Tablets (≥768px)";

		$selectFields['md']['options'] = $columnWidthSelectOptions;
		$selectFields['md']['name'] = "settings.columns.{$this->getColumn()->getIndex()}.class.md";
		$selectFields['md']['label'] = "Medium devices | Desktops (≥992px)";

		$selectFields['lg']['options'] = $columnWidthSelectOptions;
		$selectFields['lg']['name'] = "settings.columns.{$this->getColumn()->getIndex()}.class.lg";
		$selectFields['lg']['label'] = "Large devices | Desktops (≥1200px)";

		$selectFields['lg']['default'] = $this->getColumn()->getBackendColumnWidth();
		return $selectFields;


	}

	/**
	 * @return array
	 */
	public function getInputFields () {
		$inputFields['label']['name'] = "settings.columns.{$this->getColumn()->getPosition()}.label";
		$inputFields['label']['label'] = "Backend-Preview: Column Label";
		$inputFields['label']['default'] = "Column {$this->getColumn()->getPosition()}";

		$inputFields['class']['name'] = "settings.columns.{$this->getColumn()->getPosition()}.class.additional";
		$inputFields['class']['label'] = "Frontend: Additional CSS Classes";

		$inputFields['backgroundColor']['name'] = "settings.columns.{$this->getColumn()->getPosition()}.backgroundColor";
		$inputFields['backgroundColor']['label'] = "Hintergrund Farbe (backend)";
		return $inputFields;
	}

	/** @var Column */
	protected $column;


	/**
	 * @return Column
	 */
	public function getColumn () {
		return $this->column;
	}


	/**
	 * @param Column $column
	 */
	public function setColumn ($column) {
		$this->column = $column;
	}

}
