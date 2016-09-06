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
class Shopware_Controllers_Backend_ThemeImportExport extends Shopware_Controllers_Backend_ExtJs {

	public function exportAction() {
		$themeId = $this->Request()->get("theme");

        $service = $this->get("simklthemeimportexport.theme_import_export_service");
        $em = $this->get("models");

        $tplRepo = $em->getRepository('Shopware\Models\Shop\Template');
        $theme = $tplRepo->find($themeId);
        $shopRepo = $em->getRepository('Shopware\Models\Shop\Shop');
        $shop = $shopRepo->find(1);
        $settings = $service->getThemeSettingsArray(
            $theme,
            $shop
        );

        $this->Front()->Plugins()->ViewRenderer()->setNoRender();
        $this->Front()->Plugins()->Json()->setRenderer(false);

        $filename = $theme->getTemplate() . '-' . $shop->getName() . '-' . date('Y-m-d-H-i') . '.theme';
        $content = serialize($settings);


        $response = $this->Response();        
        $headers = $response->getHeaders();
        $response->setHeader('Cache-Control', 'public')
                ->setHeader('Content-Type', 'text/plain')
                ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
                ->setHeader('Content-Length', strlen($content));
    
        echo $content;

	}

}