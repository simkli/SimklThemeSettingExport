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
        $this->createConfiguration();

        return ['success' => true, 'invalidateCache' => ['backend']];    
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

        $this->bootstrap->subscribeEvent(
            'Shopware_Console_Add_Command', 
            'onAddConsoleCommand'
        );
    }

    private function registerController() {
        $this->bootstrap->registerController('Backend', 'ThemeImportExport');
    }

    /**
     * creates the backend form and adds translations
     */
    private function createConfiguration() {
        $form = $this->bootstrap->Form();
        $form->setElement('text','themeexport_filename',[
            'label' => 'Export Filename',
            'value' => '%1$s-%2$s-%3$s-%4$s.theme',
            'description' =>    'Filename for exported theme configurations. Parameters:<br>
                                %1$s - theme name<br>
                                %2$s - shop name<br>
                                %3$s - date<br>
                                %4$s - time'
        ]);
        $this->bootstrap->addFormTranslations([
            'de_DE' => [
                'themeexport_filename' => [
                    'label' => 'Export Dateiname',
                    'description' => 'Export-Dateiname. Parameter:<br>
                                        %1$s - Name der Theme<br>
                                        %2$s - Name des Shops<br>
                                        %3$s - Datum<br>
                                        %4$s - Uhrzeit'
                ]
            ]
        ]);
    }
}