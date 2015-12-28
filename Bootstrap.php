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
use Shopware\SimklThemeSettingExport\Subscriber\Backend;

class Shopware_Plugins_Backend_SimklThemeSettingExport_Bootstrap extends Shopware_Components_Plugin_Bootstrap {

    /**
     * {@inheritdoc}
     */
    public function getVersion() {
        return '1.0.0';
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
        $this->subscribeEvent('Enlight_Controller_Front_StartDispatch', 'onStartFrontDispatch');
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function update($oldVersion) {
        return true;
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
        return true;
    }



    /**
     * registers application namespace
     */
    public function afterInit() {
        $this->Application()->Loader()->registerNamespace('Shopware\SimklThemeSettingExport', $this->Path());
    }

    /**
     * adds the event subscribers
     * @param  Enlight_Event_EventArgs $args event args
     */
    public function onStartFrontDispatch(Enlight_Event_EventArgs $arguments) {
        $this->Application()->Snippets()->addConfigDir(__DIR__ . '/Snippets/');
        $this->Application()->Events()->addSubscriber(new Backend());
    }
}