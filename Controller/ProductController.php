<?php
/*************************************************************************************/
/*                                                                                   */
/*      Copyright (c) CQFDev                                                         */
/*      email : thelia@cqfdev.fr                                                     */
/*      web : http://www.cqfdev.fr                                                   */
/*                                                                                   */
/*************************************************************************************/

namespace Codebarres\Controller;

use FrancoDePort\FrancoDePort;
use FrancoDePort\Model\CustomerFranco;
use FrancoDePort\Model\CustomerFrancoQuery;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\HttpFoundation\Response;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Form\Exception\FormValidationException;
use Thelia\Model\ProductQuery;
use Thelia\Model\ProductSaleElements;
use Thelia\Model\ProductSaleElementsQuery;
use Thelia\Tools\URL;

/**
 * @author Franck Allimant <franck@cqfdev.fr>
 */
class ProductController extends BaseAdminController
{
    public function setCode($productId, $codeEan)
    {
        if (null !== $response = $this->checkAuth(AdminResources::MODULE, 'Codebarre', AccessManager::UPDATE)) {
            return $response;
        }

        $pseList = ProductSaleElementsQuery::create()->findByProductId($productId);

        /** @var ProductSaleElements $pse */
        foreach ($pseList as $pse) {
            $pse->setEanCode($codeEan)->save();
        }

        if ($this->getRequest()->isXmlHttpRequest()) {
            return new Response('OK');
        } else {
            return $this->generateRedirect(
                URL::getInstance()->absoluteUrl('admin/products/update', ['product_id' => $productId])
            );
        }
    }
}
