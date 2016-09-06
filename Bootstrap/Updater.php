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

class Updater {

    /**
     * @var \Shopware_Plugins_Backend_SimklThemeSettingExport_Bootstrap
     */
    private $bootstrap;
    
    /**
     * @param \Shopware_Plugins_Backend_SimklThemeSettingExport_Bootstrap $bootstrap
     * @param string $oldVersion
     */
    function __construct($bootstrap, $oldVersion) {
        $this->bootstrap = $bootstrap;
        $this->oldVersion = $oldVersion;
    }

    /**
     * update process
     * @param  string $oldVersion
     * @return boolean success
     */
    public function update($oldVersion) {
        $this->updateController();
        $this->updateEventSubscribers();

        return true;
    }   

    /**
     * (un-)registers controllers
     */
    private function updateController() {
        if (version_compare($this->oldVersion, '1.0.0', '<=')) {
            $this->bootstrap->registerController('Backend', 'ThemeImportExport');
        }
    }

    private function updateEventSubscribers() {
        if (version_compare($this->oldVersion, '1.0.0', '<=')) {
            $this->bootstrap->subscribeEvent(
                'Enlight_Bootstrap_InitResource_simklthemeimportexport.theme_import_export_service', 
                'onThemeImportExportService'
            );
        }
    }
}