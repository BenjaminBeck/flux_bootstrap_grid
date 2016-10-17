<?php
namespace BDM\FluxBootstrapGrid\Service\Bootstrap;

/***************************************************************
 *  Copyright notice
 *  (c) 2016 Benjamin Beck <BenjaminBeck@gmx.de>, beck digitale medien
 *  All rights reserved
 *  Usage and modifiction only with permission!
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
use BDM\FluxBootstrapGrid\Service\Bootstrap\Column;
use BDM\FluxBootstrapGrid\Service\Bootstrap\Grid;

/**
 * @author  Benjamin Beck <beck@beck-digitale-medien.de>
 */
class Row {


	/** @var Grid */
	protected $grid;


	/** @var Column[] */
	protected $columns;


	/**
	 * @return Grid
	 */
	public function getGrid () {
		return $this->grid;
	}


	/**
	 * @param Grid $grid
	 */
	public function setGrid ($grid) {
		$this->grid = $grid;
	}


	/**
	 * @return Column[]
	 */
	public function getColumns () {
		return $this->columns;
	}

	/**
	 * @return Column[]
	 */
	public function getFrontendColumns () {
		if($this->getGrid()->isReverseOrder()){
			return array_reverse($this->getColumns());
		}
		return $this->getColumns();
	}


	/**
	 * @param Column[] $columns
	 */
	public function setColumns ($columns) {
		$this->columns = $columns;
	}


	/**
	 * @param Column $column
	 */
	public function appendColumn (Column $column) {
		$column->setRow($this);
		$this->columns[] = $column;
	}


	public function getPosition (){
		$pos = 0;
		foreach($this->getGrid()->getRows() as $row){
			$pos++;
			if($this===$row){
				return $pos;
			}
		}
	}


	public function isLast () {
		$isLast = ($this->getPosition() == count($this->getGrid()->getRows()));
		return $isLast;
	}

}
