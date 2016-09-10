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
        $this->updateConfiguration();

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
        if (version_compare($this->oldVersion, '1.0.1', '<=')) {
            $this->bootstrap->subscribeEvent(
                'Enlight_Bootstrap_InitResource_simklthemeimportexport.theme_import_export_service', 
                'onThemeImportExportService'
            );
            $this->bootstrap->subscribeEvent(
                'Shopware_Console_Add_Command', 
                'onAddConsoleCommand'
            );
        }
    }

    private function updateConfiguration() {
        if (version_compare($this->oldVersion, '1.0.2', '<=')) {
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
}