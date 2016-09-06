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

namespace Shopware\SimklThemeSettingExport\Bootstrap;

class Installer {

    /**
     * @var \Shopware_Plugins_Backend_SimklThemeSettingExport_Bootstrap
     */
    private $bootstrap;
    
    /**
     * @param \Shopware_Plugins_Backend_SimklThemeSettingExport_Bootstrap $bootstrap
     */
    function __construct($bootstrap) {
        $this->bootstrap = $bootstrap;
    }

    /**
     * @return boolean success
     */
    public function install() {
        $this->registerEvents();
        $this->registerController();

        return true;    
    }

    /**
     * @return boolean success
     */
    public function uninstall() {
        return true;
    }

    private function registerEvents() {
        $this->bootstrap->subscribeEvent(
            'Enlight_Controller_Front_StartDispatch', 
            'onStartFrontDispatch'
        );

        $this->bootstrap->subscribeEvent(
            'Enlight_Bootstrap_InitResource_simklthemeimportexport.theme_import_export_service', 
            'onThemeImportExportService'
        );
    }

    private function registerController() {
        $this->bootstrap->registerController('Backend', 'ThemeImportExport');
    }
}