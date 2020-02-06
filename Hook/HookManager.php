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

namespace Codebarres\Hook;

use Codebarres\Codebarres;
use Thelia\Core\Event\Hook\HookRenderBlockEvent;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;
use Thelia\Tools\URL;

class HookManager extends BaseHook
{
    public function onMainTopMenuTools(HookRenderBlockEvent $event)
    {
        $event->add(
            [
                'id' => 'tools_menu_prixetpoints',
                'class' => '',
                'url' => URL::getInstance()->absoluteUrl('/admin/module/Codebarres'),
                'title' => $this->trans('Codes barres', [], Codebarres::DOMAIN_NAME)
            ]
        );
    }
    
    public function onProductEditBottom(HookRenderEvent $event)
    {
        $productId = $event->getArgument('product_id');
        
        $event->add(
            $this->render(
                "codebarres/product-edit.html",
                [
                    'product_id' => $productId
                ]
            )
        );
    }
    
    public function insertCodesbarresJs(HookRenderEvent $event)
    {
        $event->add($this->render("codebarres/product-edit-js.html"));
    }
    
    public function onModuleConfiguration(HookRenderEvent $event)
    {
        $event->add($this->render('codebarres/module-configuration.html'));
    }

    public function onModuleConfigurationJs(HookRenderEvent $event)
    {
        $event->add($this->render("codebarres/module-configuration-js.html"));
    }

    public function insertCodebarresCss(HookRenderEvent $event)
    {
        $event->add($this->addCSS('codebarres/assets/css/style.css'));
    }
}