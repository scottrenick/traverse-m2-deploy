<?php
namespace Traverse\Retargeting\Block\Product;

use Magento\Catalog\Helper\ImageFactory as HelperFactory;
use Magento\Catalog\Block\Product\ImageFactory as ImageFactory;

class ImageBuilder extends \Magento\Catalog\Block\Product\ImageBuilder
{

    /**
     * @var ImageFactory
     */
    protected $imageFactory;

    /**
     * @var HelperFactory
     */
    protected $helperFactory;
    
    /**
     * @var Traverse\Retargeting\Helper\Data
     */
    protected $dataHelper;

   /**
     * @param Magento\Catalog\Helper\ImageFactory $helperFactory
     * @param ImageFactory $imageFactory
     * @param Traverse\Retargeting\Helper\Data $dataHelper
     */
    public function __construct(
        HelperFactory $helperFactory,
        ImageFactory $imageFactory,
        \Traverse\Retargeting\Helper\Data $dataHelper
    ) {
        $this->dataHelper = $dataHelper;
        $this->helperFactory = $helperFactory;
        $this->imageFactory = $imageFactory;
    }

    /**
     * Create image block
     *
     * @return \Magento\Catalog\Block\Product\Image with extra custom attributes in data
     */
    public function create()
    {
        /** @var \Magento\Catalog\Helper\Image $helper */
        $helper = $this->helperFactory->create()
            ->init($this->product, $this->imageId);

        $template = $helper->getFrame()
            ? 'Magento_Catalog::product/image.phtml'
            : 'Magento_Catalog::product/image_with_borders.phtml';

        try {
            $imagesize = $helper->getResizedImageInfo();
        } catch (NotLoadInfoImageException $exception) {
            $imagesize = [$helper->getWidth(), $helper->getHeight()];
        }

        $data = [
            'data' => [
                'template' => $template,
                'image_url' => $helper->getUrl(),
                'width' => $helper->getWidth(),
                'height' => $helper->getHeight(),
                'label' => $helper->getLabel(),
                'ratio' =>  $this->getRatio($helper),
                'custom_attributes' => $this->getCustomAttributes(),
                'resized_image_width' => $imagesize[0],
                'resized_image_height' => $imagesize[1],
            ],
        ];

        if( $this->dataHelper->isEnabled() ) {
            $prod = $this->product->load($this->product->getId());
            $event_url = $this->dataHelper->getEventUrl();
            $prod_url = $prod->getProductUrl();
            $prod_id = $prod->getId();
            $prod_sku = $prod->getSku();
            $prod_name = urlencode($prod->getName());
            $prod_price = $prod->getFinalPrice();
            $prod_desc = urlencode($prod->getData('description'));
            $prod_currency = $this->dataHelper->getCurrencyCode();

            $prod_data = array(
                        'event_url'=>$event_url,
                        'prod_url'=>$prod_url,
                        'id'=>$prod_id,
                        'sku'=>$prod_sku,
                        'price'=>$prod_price,
                        'currency'=>$prod_currency,
                        'image'=>$helper->getUrl(),
                        'name'=>$prod_name,
                        'description'=>$prod_desc
                        );
            $tr_data = $this->dataHelper->getJsonDataInsert($prod_data);
            $data['data']['custom_attributes'] .= $tr_data;
        }

        return $this->imageFactory->create($data);
    }

    
}
