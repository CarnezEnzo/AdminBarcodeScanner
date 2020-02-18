<?php

namespace AdminBarcodeScanner\EventListeners;

use AdminBarcodeScanner\Model\ProductEanQuery;
use AdminBarcodeScanner\Model\ProductEan;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Constraints;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Core\Event\TheliaFormEvent;
use AdminBarcodeScanner\AdminBarcodeScanner;
use Thelia\Core\HttpFoundation\Request;
use Thelia\Core\Translation\Translator;
use Thelia\Tools\URL;

/**
 * Class ProductExtendPriceFormListener
 * @package AdminBarcodeScanner\EventListeners
 */
class ProductExtendPriceFormListener implements EventSubscriberInterface
{
    /**
     * @var Request
     */
    private $request;

    public function __construct(Request $request)
    {

        $this->request = $request;
    }
    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
            TheliaEvents::FORM_BEFORE_BUILD . ".thelia_product_default_sale_element_update_form" => ['addFieldToForm', 128],
            TheliaEvents::FORM_BEFORE_BUILD . '.thelia_product_default_sale_element_update_form' => ['extendProductPriceForm', 100]
        ];
    }

    /**
     * Add a custom EAN price input to the product
     *
     * @param TheliaFormEvent $event
     */
    public function extendProductPriceForm(TheliaFormEvent $event)
    {
        $event
            ->getForm()
            ->getFormBuilder()
            ->addEventListener(FormEvents::POST_SUBMIT, [$this, 'handleExtendedData'], 0);

        $codeEan = null;
        $data = $event->getForm()->getFormBuilder()->getData();
        if (isset($data['product_sale_element_id'])) {
            $pse = $data['product_sale_element_id'];
            $productEan = ProductEanQuery::create()->findPk($pse);

            if ($productEan !== null)
                $codeEan = $productEan->getEanCode();
        }

        $event->getForm()->getFormBuilder()
            ->add(
                'custom_ean',
                TextType::class,
                [
                    'required' => false,
                    'attr' => [
                        'placeholder' => Translator::getInstance()->trans(
                            'Current custom EAN code',
                            [],
                            AdminBarcodeScanner::DOMAIN_NAME
                        )
                    ],
                    'label' => Translator::getInstance()->trans(
                        'Custom EAN Code',
                        [],
                        AdminBarcodeScanner::DOMAIN_NAME
                    ),
                    'data'=> $codeEan
                ]
            );
    }

    /**
     * Create or update product's custom EAN
     *
     * @param FormEvent $formEvent
     * @throws \Exception
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function handleExtendedData(FormEvent $formEvent)
    {
        if (!$formEvent->getForm()->isValid()) {
            return;
        }

        $data = $formEvent->getData();

        $productEan = ProductEanQuery::create()
            ->filterByProductSaleId($data['product_sale_element_id'])
            ->useProductSaleElementsQuery()
            ->filterByEanCode($data['ean_code'])
            ->endUse()
            ->findOne();

        if (null !== $productEan)
        {
            $productEan
            ->setEanCode($data['custom_ean'])
            ->save();
        } else {
          // Create a new product EAN entry
          $newProduct = new ProductEan();
            $newProduct->setProductSaleId($data['product_sale_element_id'])
            ->setEanCode(($data['custom_ean']))
            ->save();
        }
    }
}
