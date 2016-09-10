<?php
/**
 * Import / export plugin for theme configurations
 *
 * @category   Shopware
 * @package    Shopware\Plugins\SimklThemeSettingExport
 * @author     Simon Klimek <me@simonklimek.de>
 * @copyright  2015 Simon Klimek ( http://simonklimek.de )
 * @license    http://www.gnu.org/licenses/agpl-3.0.en.html GNU AFFERO GENERAL PUBLIC LICENSE
 */

namespace Shopware\SimklThemeSettingExport\Commands;

use Shopware\Commands\ShopwareCommand;

abstract class Command extends ShopwareCommand {
    /**
     * @var \Shopware\SimklThemeSettingExport\Components\ThemeImportExportService
     */
    private $service = null;

    /**
     * @return \Shopware\SimklThemeSettingExport\Components\ThemeImportExportService
     */
    protected function getService() {
        if ($this->service == null) {
            $this->service = $this->container->get('simklthemeimportexport.theme_import_export_service');
        }
        return $this->service;
    }

    /**
     * returns a Template model specified by $theme
     * @param  mixed $theme id or name
     * @return Shopware\Models\Shop\Template
     */
    protected function getThemeModel($theme) {
        $em = $this->container->get('models');
        $tplRepo = $em->getRepository('Shopware\Models\Shop\Template');
        if (is_numeric($theme)) 
            return  $tplRepo->find($theme);
        $themes = $tplRepo->findBy(['template'=>$theme]);
        if (count($themes) >= 1) return $themes[0];

        return null;
    }

    /**
     * returns a Shop model
     * @param  mixed $shop id or name
     * @return Shopware\Models\Shop\Shop
     */
    protected function getShopModel($shop) {
        $em = $this->container->get('models');
        $shopRepo = $em->getRepository('Shopware\Models\Shop\Shop');
        if (is_numeric($shop)) 
            return $shopRepo->find($shop);

        $shops = $shopRepo->findBy(['name' => $shop]);
        if (count($shops) >= 1) return $shops[0];

        return null;
    }
}