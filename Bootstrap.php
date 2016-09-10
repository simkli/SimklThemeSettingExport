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
use Shopware\SimklThemeSettingExport\Bootstrap\Installer,
    Shopware\SimklThemeSettingExport\Bootstrap\Updater,
    Shopware\SimklThemeSettingExport\Components\ThemeImportExportService,
    Shopware\SimklThemeSettingExport\Subscriber\Backend;

class Shopware_Plugins_Backend_SimklThemeSettingExport_Bootstrap extends Shopware_Components_Plugin_Bootstrap {

    const VERSION = '1.0.2';

    /**
     * {@inheritdoc}
     */
    public function getVersion() {
        return $this::VERSION;
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel() {
        return 'Theme Setting Export';
    }


    /**
     * {@inheritdoc}
     */
    public function getCapabilities() {
        return array(
            'install' => true,
            'enable' => true,
            'update' => true,
            'secureUninstall' => false
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getInfo() {
        return array(
            'version' => $this->getVersion(),
            'label' => $this->getLabel(),
            'autor' => 'Simon Klimek',
            'link' => 'https://github.com/simkli',
            'description' => 'with this simple plugin you can export and import your theme configurations'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function install() {
        if (!$this->assertMinimumVersion('5')) {
            return array('success' => false, 'message' => "this plugin requires at least Shopware version 5");
        }
        return (new Installer($this))->install();
    }

    /**
     * {@inheritdoc}
     */
    public function update($oldVersion) {
        return (new Updater($this,$oldVersion))->update();
    }
    /**
     * {@inheritdoc}
     */
    public function enable() {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function uninstall() {
        return (new Installer($this))->uninstall();
    }

    /**
     * registers application namespace
     */
    public function afterInit() {
        $this->Application()->Loader()->registerNamespace(
            'Shopware\SimklThemeSettingExport', 
            $this->Path()
        );
    }

    /**
     * adds the event subscribers
     * @param  Enlight_Event_EventArgs $args event args
     */
    public function onStartFrontDispatch(\Enlight_Event_EventArgs $arguments) {
        $this->Application()->Snippets()->addConfigDir(__DIR__ . '/Snippets/');
        $this->Application()->Events()->addSubscriber(new Backend());
    }

    public function onThemeImportExportService() {
        return new ThemeImportExportService($this->get('models'));
    }

    // TODO Import / Export Commands
    public function onAddConsoleCommand(\Enlight_Event_EventArgs $arguments) {
        return [];
    }
}