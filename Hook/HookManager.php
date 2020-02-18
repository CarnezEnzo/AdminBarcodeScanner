<?php
/*************************************************************************************/
/*                                                                                   */
/*      Copyright (c) Franck Allimant, CQFDev                                        */
/*      email : thelia@cqfdev.fr                                                     */
/*      web : http://www.cqfdev.fr                                                   */
/*                                                                                   */
/*************************************************************************************/

/**
 * Created by Franck Allimant, CQFDev <franck@cqfdev.fr>
 * Date: 05/03/2016 18:11
 */

namespace AdminBarcodeScanner\Hook;

use AdminBarcodeScanner\AdminBarcodeScanner;
use Propel\Runtime\ActiveQuery\Criteria;
use Thelia\Core\Event\Hook\HookRenderBlockEvent;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;
use Thelia\Model\ProductCategoryQuery;
use Thelia\Tools\URL;
use Thelia\Model\Category;
use Thelia\Model\CategoryQuery;
use Thelia\Model\Product;
use Thelia\Model\ProductQuery;
use AdminBarcodeScanner\Model\ProductEan;
use AdminBarcodeScanner\Model\ProductEanQuery;

class HookManager extends BaseHook
{
    public function onMainTopMenuTools(HookRenderBlockEvent $event)
    {
        $event->add(
            [
                'id' => 'tools_menu_barcode',
                'class' => '',
                'url' => URL::getInstance()->absoluteUrl('/admin/module/AdminBarcodeScanner'),
                'title' => $this->trans('Barcodes', [], AdminBarcodeScanner::DOMAIN_NAME)
            ]
        );
    }

    public function onProductEditBottom(HookRenderEvent $event)
    {
        $productId = $event->getArgument('product_id');

        $event->add(
            $this->render(
                "barcodes/product-edit.html",
                [
                    'product_id' => $productId
                ]
            )
        );
    }

    public function insertBarcodeJs(HookRenderEvent $event)
    {
        $event->add($this->render("barcodes/product-edit-js.html"));
    }

    public function onModuleConfiguration(HookRenderEvent $event)
    {
        $event->add(
            $this->render(
                'barcodes/module-configuration.html',
                [
                    'main_table' => AdminBarcodeScanner::getConfigValue(AdminBarcodeScanner::MAIN_TABLE)
                ]
            ));
        $event->add($this->addCSS('barcodes/assets/css/style-config.css'));
    }

    public function onModuleConfigurationJs(HookRenderEvent $event)
    {
        $event->add($this->render("barcodes/module-configuration-js.html"));
    }

    public function insertBarcodeCss(HookRenderEvent $event)
    {
        $event->add($this->addCSS('barcodes/assets/css/style.css'));
    }
}
