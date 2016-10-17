<?php
namespace BDM\FluxBootstrapGrid\Service\Bootstrap;

/***************************************************************
 *  Copyright notice
 *  (c) 2016 Benjamin Beck <BenjaminBeck@gmx.de>, beck digitale medien
 *  All rights reserved
 *  Usage and modifiction only with permission!
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
use BDM\FluxBootstrapGrid\Service\Bootstrap\Row;
use BDM\FluxBootstrapGrid\Service\Bootstrap\Column;

/**
 * @author  Benjamin Beck <beck@beck-digitale-medien.de>
 */
class Grid {

	/** @var Row[] */
	protected $rows;

	/** @var Sheet[] */
	protected $sheets;

	/** @var  boolean */
	protected $equalWidth;

	/** @var  boolean */
	protected $reverseOrder;

	/** @var  string */
	protected $additionalCssClasses;




	/**
	 * @return boolean
	 */
	public function isReverseOrder () {
		return $this->reverseOrder;
	}

	/**
	 * @return boolean
	 */
	public function getIsReverseOrder () {
		return $this->reverseOrder;
	}


	/**
	 * @param boolean $reverseOrder
	 */
	public function setReverseOrder ($reverseOrder) {
		$this->reverseOrder = $reverseOrder;
	}


	/**
	 * @return boolean
	 */
	public function isEqualWidth () {
		return $this->equalWidth;
	}


	/**
	 * @param boolean $equalWidth
	 */
	public function setEqualWidth ($equalWidth) {
		$this->equalWidth = $equalWidth;
	}


	protected function __constructor(){
		/*for($row=0;$row<$rowCount;$row++){

		}*/
	}

	/**
	 * @return Row[]
	 */
	public function getRows () {
		return $this->rows;
	}


	/**
	 * @param Row[] $rows
	 */
	public function setRows ($rows) {
		foreach($rows as $row){
			$row->setGrid($this);
		}
		$this->rows = $rows;
	}





	/**
	 * @param Row $row
	 */
	public function appendRow (Row $row) {
		$row->setGrid($this);
		$this->rows[] = $row;
	}

	public static function createInstanceFromSettings($settings){
		$grid = new static();

		$rowCount = (int)$settings['rowCount'];
		if($rowCount==0) $rowCount = 1;// fallback for old data
		$columnCount = (int)$settings['columnCount'];
		$grid->setEqualWidth((boolean)$settings['equalwidth']);
		$grid->setReverseOrder((boolean)$settings['reverseResponsive']);
		$grid->setAdditionalCssClasses( $settings['class']['additional'] );
		for($rowIndex=0;$rowIndex<$rowCount;$rowIndex++){
			$row = new Row();




			for($columnIndex=0;$columnIndex<$columnCount;$columnIndex++){




				$column = new Column();


				if($grid->isEqualWidth()){
					$columnAccessIndex = 0;
				}else{
					$columnAccessIndex = $columnIndex;
				}

				$column->setSizeLG((int) $settings['columns'][$columnAccessIndex]['class']['lg']);
				$column->setSizeMD((int) $settings['columns'][$columnAccessIndex]['class']['md']);
				$column->setSizeSM((int) $settings['columns'][$columnAccessIndex]['class']['sm']);
				$column->setSizeXS((int) $settings['columns'][$columnAccessIndex]['class']['xs']);
				$column->setClassAdditional($settings['columns'][$columnAccessIndex]['class']['additional']);
				$column->setLabel($settings['columns'][$columnAccessIndex]['label']);
				$column->setBackendBackgroundColor($settings['columns'][$columnAccessIndex]['backgroundColor']);

				if($rowIndex==0){

					if(!$grid->isEqualWidth()){
						$sheet = new Sheet();
						$sheet->setColumn($column);
						$grid->appendSheet($sheet);
					}else{
						if($columnIndex==0){
							$sheet = new Sheet();
							$sheet->setColumn($column);
							$grid->appendSheet($sheet);
						}
					}
				}
				$row->appendColumn($column);
			}

			$grid->appendRow($row);
		}



		return $grid;
	}


	/**
	 * @return Sheet[]
	 */
	public function getSheets () {
		return $this->sheets;
	}


	/**
	 * @param Sheet[] $sheets
	 */
	public function setSheets ($sheets) {
		$this->sheets = $sheets;
	}
	/**
	 * @param Sheet $sheet
	 */
	public function appendSheet ($sheet) {
		$this->sheets[] = $sheet;
	}


	public function getCountColumns () {
		return count($this->getRows()[0]->getColumns());
	}


	public function getCountRows () {
		return count($this->getRows());
	}


	/**
	 * @return string
	 */
	public function getAdditionalCssClasses () {
		return $this->additionalCssClasses;
	}


	/**
	 * @param string $additionalCssClasses
	 */
	public function setAdditionalCssClasses ($additionalCssClasses) {
		$this->additionalCssClasses = $additionalCssClasses;
	}

}
