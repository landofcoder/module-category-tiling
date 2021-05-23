<?php
/**
 * Landofcoder
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Landofcoder.com license that is
 * available through the world-wide-web at this URL:
 * https://landofcoder.com/terms
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category   Landofcoder
 * @package    Lof_CategoryTiling
 * @copyright  Copyright (c) 2021 Landofcoder (https://www.landofcoder.com/)
 * @license    https://landofcoder.com/terms
 */
namespace Lof\FeaturedCategory\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\StoreManagerInterface;

class FeaturedCategoryWidget extends Template implements BlockInterface
{

    protected $_template = "widget/featured_categories.phtml";

    protected $categoryRepository;
    protected $_categoryCollectionFactory;
    protected $_categoryRepository;
    protected $_storeManager;
    protected $catalogHelperOutput;
    protected $helperImage;

    public function __construct(
    		Context $context, 
    		StoreManagerInterface $storeManager, 
    		CollectionFactory $categoryCollectionFactory,
    		\Magento\Catalog\Model\CategoryRepository $categoryRepository,
            \Magento\Catalog\Helper\Image $helperImage,
            \Magento\Catalog\Helper\Output $catalogHelperOutput
    	)
    {
 
        $this->_storeManager = $storeManager;
        $this->_categoryCollectionFactory = $categoryCollectionFactory;
        $this->_categoryRepository = $categoryRepository;
        $this->helperImage = $helperImage;
        $this->catalogHelperOutput = $catalogHelperOutput;
        parent::__construct($context);
    }

    /**
     * Get value of widgets' id_path parameter
     *
     * @return mixed|string
     */
    private function getParentCategoryId()
    {
        return str_replace('category/','',$this->getData('id_path'));
    }

    public function getCategoryName(){
    	return 
    		$this->_categoryRepository->get(
    							$this->getParentCategoryId()
    						)->getName();
    }


    /**
     * Get value of widgets' id_path parameter
     *
     * @return mixed|string
     */
    private function getTopContent()
    {
        return $this->getData('top_content');
    }

    /**
     * Get value of widgets' id_path parameter
     *
     * @return mixed|string
     */
    private function getCategoryCount()
    {
        return $this->getData('category_count');
    }

    /**
     * Get value of widgets' image_height parameter
     *
     * @return mixed|string
    */
    public function getThumbnailHeight()
    {
        return $this->getData('image_height');
    }
    
    /**
     * Get value of widgets' image_height parameter
     *
     * @return mixed|string
    */
    public function getThumbnailWidth()
    {
        return $this->getData('image_width');
    }

    public function isShowThumbnail() {
        return $this->getData('thumbnail');
    }

    /**
     *  Get the category collection based on the ids
     *
     * @return array
     */
    public function getCategoryCollection()
    {
        $category = $this->_categoryRepository->get(
    							$this->getParentCategoryId()
    						);
        return $category->getChildrenCategories();

    }

    public function getDescription($category)
    {
        $description = $category->getDescription();
        if ($description) {
            $categoryDescription = $this->catalogHelperOutput->categoryAttribute($category, $description, 'description');
        } else {
            $categoryDescription = '';
        }
        return trim($categoryDescription);
    }

    public function getImage($category)
    {
        if($this->isShowThumbnail()!=1){
            return $this->getImageUrl($category);
        }else{
            $id = $category->getId();
            $category = $this->categoryFactory->create();
            $category->load($id);
            $image = $category->getData('category_thumbnail');
        }
        return $this->getImageUrl($image);
    }

    public function getImageUrl($image)
    {
        if(is_object($image)){
            $image = $image->getImage();
        }
        if(strpos($image, "media/")) $image = strstr($image,'/media');
        elseif($image!=NULL){
            $image = 'catalog/category/'.$image;
        }
        $image = str_replace('media/', '',  $image);

        if($image) {
            $url = $this->storeManager->getStore()->getBaseUrl( \Magento\Framework\UrlInterface::URL_TYPE_MEDIA ) . $image;
        } else {
            $url = $this->helperImage->getDefaultPlaceholderUrl('small_image');
        }

        return $url;
    }

}