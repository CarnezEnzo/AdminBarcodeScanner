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

namespace Codebarres\Controller;

use Thelia\Controller\Front\BaseFrontController;
use Thelia\Model\ProductSaleElementsQuery;
use Thelia\Tools\URL;

class SearchController extends BaseFrontController
{
    public function search($codeEan)
    {
        if (null !== $pse = ProductSaleElementsQuery::create()->findOneByEanCode($codeEan)) {
            $product = $pse->getProduct();

            // Redirect to product page
            return $this->generateRedirect(
                URL::getInstance()->absoluteUrl('admin/products/update', ['product_id' => $product->getId()])
            );
        } else {
            return $this->generateRedirect(URL::getInstance()->absoluteUrl('/codebarre', [
                'nocode' => $codeEan,
            ]));
        }
    }
}