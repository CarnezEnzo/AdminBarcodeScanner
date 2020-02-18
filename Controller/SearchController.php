<?php
/*************************************************************************************/
/*                                                                                   */
/*      This file is not free software                                               */
/*                                                                                   */
/*      Copyright (c) Franck Allimant, CQFDev                                        */
/*      email : thelia@cqfdev.fr                                                     */
/*      web : http://www.cqfdev.fr                                                   */
/*                                                                                   */
/*************************************************************************************/

/**
 * Created by Franck Allimant, CQFDev <franck@cqfdev.fr>
 * Date: 02/05/2016 10:40
 */

namespace AdminBarcodeScanner\Controller;

use AdminBarcodeScanner\Model\ProductEan;
use AdminBarcodeScanner\Model\ProductEanQuery;
use Thelia\Controller\Front\BaseFrontController;
use Thelia\Model\ProductSaleElementsQuery;
use Thelia\Model\ProductSaleElements;
use AdminBarcodeScanner\AdminBarcodeScanner;
use Thelia\Tools\URL;
use Thelia\Core\HttpFoundation\Response;

class SearchController extends BaseFrontController
{
    public function search($codeEan)
    {
        $config = AdminBarcodeScanner::getConfigValue(AdminBarcodeScanner::MAIN_TABLE);
        if ($config == 'default')
            $pse = ProductSaleElementsQuery::create()->findOneByEanCode($codeEan);
            if (null !== $pse)
                $product = $pse->getProduct();
        else {
            $pse = ProductEanQuery::create()->findOneByEanCode($codeEan);
            if (null !== $pse)
                $product = $pse->getProductSaleElements()->getProduct();
        }

        if (null !== $pse) {
            // Redirect to product update page
            return $this->generateRedirect(
                URL::getInstance()->absoluteUrl(
                  'admin/products/update',
                  [
                    'product_id' => $product->getId(),
                    'current_tab' => 'prices'
                  ]
                )
            );
        }
        else {
            return new Response('', 404);
        }
    }
}
