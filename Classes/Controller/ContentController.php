<?php
namespace BDM\FluxBootstrapGrid\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2015  <>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use FluidTYPO3\Fluidcontent\Controller\ContentController as AbstractController;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;
use TYPO3\CMS\Frontend\Resource\FileCollector;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;

/**
 * Content Controller
 *
 * @subpackage Controller
 * @route      off
 */
class ContentController extends AbstractController {

    /**
     * @var \TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder
     * @inject
     */
    protected $uriBuilder = NULL;

    /**
     * articleRepository
     *
     * @var \Bdm\BdmProduct\Domain\Repository\ArticleRepository
     * @inject
     */
    protected $articleRepository = NULL;

    /**
     * attributeRepository
     *
     * @var \Bdm\BdmProduct\Domain\Repository\AttributeRepository
     * @inject
     */
    protected $attributeRepository = NULL;

	/**
	 * @param ViewInterface $view
	 * @return void
	 */
	public function initializeView(ViewInterface $view) {
		parent::initializeView($view);


		$record     = $this->getRecord();
		$this->flexValues = $this->provider->getFlexFormValues( $record );


		$cObj = $this->configurationManager->getContentObject();

		/** @var FileCollector $fileCollector */
        $fileCollector = GeneralUtility::makeInstance(FileCollector::class);

		$fileCollector->addFilesFromRelation('tt_content', 'image', $cObj->data);
		$files = $fileCollector->getFiles();
		$this->view->assign('images',$files);

		/** @var FileCollector $fileCollector */
        $fileCollector = GeneralUtility::makeInstance(FileCollector::class);
		$fileCollector->addFilesFromRelation('tt_content', 'header_image', $cObj->data);
		$files = $fileCollector->getFiles();
		$this->view->assign('headerImages',$files);


	}

	/**
	 * @return string
	 */
	public function ceTeaserLetterAction () {}

	/**
	 * @return string
	 */
	public function ceTeaserButtonWideAction () {}

	/**
	 * @return string
	 */
	public function ceContactAction () {}


	/**
	 * @return string
	 */
	public function ceTeaserXxlAction () {}

    public function ceSliderAction(){}
    public function ceNewsletterAction(){}
    public function ceFooterAction(){}

	/**
	 * @return string
	 */
	public function ceSliderItemAction () {}


	/**
	 * @return string
	 */
	public function ceHistoryImageAction () {}

	/**
	 * @return string
	 */
	public function ceWorldmapAction () {


	}

	/**
	 * @return string
	 */
	public function ceGridAction () {
		$cc = 1;

		$numberOfColumns = (int) $this->flexValues['settings']['columnCount'];


	}
// http://sucocms.panama-digital.de/druckueberwachung/mechanische-druckschalter/detail/?tx_bdmproduct_productlist%5Battributes%5D%5B0%5D=10&tx_bdmproduct_productlist%5Battributes%5D%5B1%5D=5&tx_bdmproduct_productlist%5Baction%5D=find&tx_bdmproduct_productlist%5Bcontroller%5D=Article&cHash=f813697460ebae0654b8690ff2ce8dac&tx_bdmproduct_productlist%5Battributes%5D%5B2%5D=19
// http://sucocms.panama-digital.de/druckueberwachung/mechanische-druckschalter/detail/?tx_bdmproduct_productlist%5Battributes%5D%5B0%5D=10&tx_bdmproduct_productlist%5Battributes%5D%5B1%5D=5&tx_bdmproduct_productlist%5Baction%5D=show&tx_bdmproduct_productlist%5Bcontroller%5D=Product&cHash=4be2a1c1698cd46cccc97f0a83785d6b

	/**
	 * @return string
	 */
	public function ceProductFilterTeaserAction () {
		$record     = $this->getRecord();
		$flexValues = $this->provider->getFlexFormValues( $record );




/*
		$this->uriBuilder->reset();
        $this->uriBuilder->setTargetPageUid(66);
        $this->uriBuilder->setCreateAbsoluteUri(true);
        $this->uriBuilder->setAddQueryString(TRUE);
        $this->uriBuilder->setArguments(array(
            'tx_switmb_event' => array(
                'attrubutes' => array(1,2)
            )
        ));
        $uri = $this->uriBuilder->build();*/


		$this->uriBuilder->reset();
        $this->uriBuilder->setTargetPageUid(66);
		$link = $this->uriBuilder->uriFor(
			$actionName = 'show',
			$controllerArguments = array(
				'attributes' => explode(',',$flexValues['attributes'])
			),
			$controllerName = 'Product',
			$extensionName = 'BdmProduct',
			$pluginName = 'Productlist'
		);







		$attributesArray = explode(',',$flexValues['attributes']);
		$this->view->assign('attributes',$attributesArray);
		$this->view->assign('link',$link);


		$cc=1;
	}



}
