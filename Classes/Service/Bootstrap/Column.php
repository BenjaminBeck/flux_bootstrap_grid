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
class Column {


	/** @var  int */
	protected $sizeXS = 0;

	/** @var  int */
	protected $sizeSM = 0;

	/** @var  int */
	protected $sizeMD = 0;

	/** @var  int */
	protected $sizeLG = 0;

	/** @var  array */
	protected $classAdditional;

	/** @var  string */
	protected $backendBackgroundColor;

	/** @var  string */
	protected $label;

	/** @var \BDM\FluxBootstrapGrid\Service\Bootstrap\Row */
	protected $row;


	/**
	 * @return string
	 */
	public function getFluxFieldName () {
		$fluxFieldName = 'column'.$this->getPosition()-1;
		return $fluxFieldName;
	}





	/**
	 * @return int
	 */
	public function getSizeXS () {

		if($this->sizeXS==0){
			return 12;
		}
		return $this->sizeXS;
	}


	/**
	 * @param int $sizeXS
	 */
	public function setSizeXS ($sizeXS) {

		$this->sizeXS = $sizeXS;
	}


	/**
	 * @return int
	 */
	public function getSizeSM () {
		if($this->sizeSM==0){
			return $this->getSizeXS();
		}
		return $this->sizeSM;
	}


	/**
	 * @param int $sizeSM
	 */
	public function setSizeSM ($sizeSM) {
		$this->sizeSM = $sizeSM;
	}


	/**
	 * @return int
	 */
	public function getSizeMD () {
		if($this->sizeMD==0){
			return $this->getSizeSM();
		}
		return $this->sizeMD;
	}


	/**
	 * @param int $sizeMD
	 */
	public function setSizeMD ($sizeMD) {
		$this->sizeMD = $sizeMD;
	}


	/**
	 * @return int
	 */
	public function getSizeLG () {
		if($this->sizeLG==0){
			return $this->getSizeMD();
		}
		return $this->sizeLG;
	}


	/**
	 * @param int $sizeLG
	 */
	public function setSizeLG ($sizeLG) {
		$this->sizeLG = $sizeLG;
	}


	/**
	 * @return array
	 */
	public function getClassAdditional () {
		return $this->classAdditional;
	}


	/**
	 * @param array $classAdditional
	 */
	public function setClassAdditional ($classAdditional) {
		$this->classAdditional = $classAdditional;
	}


	/**
	 * @return string
	 */
	public function getBackendBackgroundColor () {
		return $this->backendBackgroundColor;
	}


	/**
	 * @param string $backendBackgroundColor
	 */
	public function setBackendBackgroundColor ($backendBackgroundColor) {
		$this->backendBackgroundColor = $backendBackgroundColor;
	}


	/**
	 * @return Row
	 */
	public function getRow () {
		return $this->row;
	}


	/**
	 * @param Row $row
	 */
	public function setRow ($row) {
		$this->row = $row;
	}


	/**
	 * @return string
	 */
	public function getLabel () {

		return $this->label;
	}


	/**
	 * @param string $label
	 */
	public function setLabel ($label) {
		$this->label = $label;
	}


	public function getPosition () {
		$pos = 0;
		foreach($this->getRow()->getColumns() as $column){
			$pos++;
			if($this===$column){
				return $pos;
			}
		}
	}
	public function getIndex () {
		return $this->getPosition()-1;
	}

	public function isLast(){
		$isLast = $this->getPosition() == $this->getRow()->getGrid()->getCountColumns();
		return $isLast;
	}




	public function getBackendColumnWidth () {
		$backendColumnWidth = 12;
		if($this->getSizeLG()){
			$backendColumnWidth = $this->getSizeLG();
		}
		if($this->getSizeMD()){
			$backendColumnWidth = $this->getSizeMD();
		}
		if($this->getSizeSM()){
			$backendColumnWidth = $this->getSizeSM();
		}

		return $backendColumnWidth;
	}


	public function getBackendStyle () {
		$countColumns = $this->getRow()->getGrid()->getCountColumns();

		$ccx = 12 / $countColumns;

		$widthInPc = ($ccx / 0.12);

		$gridColumnStyle = "width: {$widthInPc}%;";
		if(!$this->isLast()){
			$gridColumnStyle .= "border-right: dashed grey 1px;";
		}
		if(!$this->getRow()->isLast()){
			$gridColumnStyle .= "border-bottom: dashed grey 1px;";
		}
		return $gridColumnStyle;
	}


	public function getFluxName (){

		if($this->getRow()->getPosition()==1){
			// backward compatibility
			$gridColumnName = "column".($this->getPosition()-1);
		}else{
			$gridColumnName = "row{$this->getRow()->getPosition()}column{$this->getPosition()}";
		}
		return $gridColumnName;

	}


	public function getFluxLabel (){

		$gridColumnLabel = "Spalte {$this->getPosition()}";
		if($this->getRow()->getGrid()->getCountRows() > 1){
			$gridColumnLabel = "Zeile {$this->getRow()->getPosition()} / ".$gridColumnLabel;
		}
        if($this->getRow()->getPosition()==1){
            $gridColumnLabel .= "<br>Classes:" . $this->getFrontendClasses();
        }
		return $gridColumnLabel;
		#return $gridColumnLabel."({$this->getFluxName()})";

	}


	public function getSumPrecedingColumnsLG (){
		$sumPrecedingColumns = 0;
		foreach($this->getRow()->getFrontendColumns() as $column){
			if($column!==$this){
				$sumPrecedingColumns += $column->getSizeLG();
			}else{
				return $sumPrecedingColumns;
			}
		}
	}
	public function getSumPrecedingColumnsMD (){
		$sumPrecedingColumns = 0;
		foreach($this->getRow()->getFrontendColumns() as $column){
			if($column!==$this){
				$sumPrecedingColumns += $column->getSizeMD();
			}else{
				return $sumPrecedingColumns;
			}
		}
	}
	public function getSumPrecedingColumnsSM (){
		$sumPrecedingColumns = 0;
		foreach($this->getRow()->getFrontendColumns() as $column){
			if($column!==$this){
				$sumPrecedingColumns += $column->getSizeSM();
			}else{
				return $sumPrecedingColumns;
			}
		}
	}



	public function getFrontendClasses (){



		//$columnCount = $this->getRow()->getGrid()->getCountColumns();

		$frontendClasses = [];
		if($this->getSizeLG()){
			$frontendClasses[] = "col-lg-{$this->getSizeLG()}";
		}
		if($this->getSizeMD()){
			$frontendClasses[] = "col-md-{$this->getSizeMD()}";
		}
		if($this->getSizeSM()){
			$frontendClasses[] = "col-sm-{$this->getSizeSM()}";
		}
		if($this->getSizeXS()){
			$frontendClasses[] = "col-xs-{$this->getSizeXS()}";
		}
		if($this->getClassAdditional()!=""){
			$frontendClasses[] = $this->getClassAdditional();
		}


		if($this->getRow()->getGrid()->isReverseOrder()){

			$move = 0;
			$selfWidth = $this->getSizeLG();
			$selfOffset = $this->getSumPrecedingColumnsLG();
			$prevSum = $this->getSumPrecedingColumnsLG();
			$move = 12 - $selfWidth - $selfOffset - $prevSum;
			if($move<0){
				$move = $move * -1;
				$frontendClasses[] = "col-lg-pull-{$move}";
			}else{
				$frontendClasses[] = "col-lg-push-{$move}";
			}

			$move = 0;
			$selfWidth = $this->getSizeMD();
			$selfOffset = $this->getSumPrecedingColumnsMD();
			$prevSum = $this->getSumPrecedingColumnsMD();
			$move = 12 - $selfWidth - $selfOffset - $prevSum;
			if($move<0){
				$move = $move * -1;
				$frontendClasses[] = "col-md-pull-{$move}";
			}else{
				$frontendClasses[] = "col-md-push-{$move}";
			}


			$move = 0;
			$selfWidth = $this->getSizeSM();
			$selfOffset = $this->getSumPrecedingColumnsSM();
			$prevSum = $this->getSumPrecedingColumnsSM();
			$move = 12 - $selfWidth - $selfOffset - $prevSum;
			if($move<0){
				$move = $move * -1;
				$frontendClasses[] = "col-sm-pull-{$move}";
			}else{
				$frontendClasses[] = "col-sm-push-{$move}";
			}


			/*if($precedingColumnsSize <= 6){
				$frontendClasses[] = "col-lg-push-{$}";
			}*/
		}





		$frontendClassesString = implode(' ',$frontendClasses);








		return $frontendClassesString;
	}
}
