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

namespace Shopware\SimklThemeSettingExport\Subscriber;
use Enlight\Event\SubscriberInterface;

class Backend implements SubscriberInterface {


    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents() {
        return array(
            'Enlight_Controller_Action_PostDispatchSecure_Backend_Theme' => 'onPostDispatchSecureBackendTheme',
        );
    }

    /**
     * hook for extending the theme ext js app
     * @param  \Enlight_Event_EventArgs hook arguments
     */
    public function onPostDispatchSecureBackendTheme(\Enlight_Event_EventArgs $arguments) {
        $themeCtl = $arguments->getSubject();
        $view = $themeCtl->View();
        $request  = $themeCtl->Request();
        $response = $themeCtl->Response();

        $view->addTemplateDir(
            dirname(__DIR__).'/Views/'
        );
 
        if ($request->getActionName() === 'index') {
            $view->extendsTemplate(
                'backend/theme/simkl_theme_setting_export/app.js'
            );
        }
        
        if ($request->getActionName() === 'load') {
            $view->extendsTemplate(
                'backend/theme/simkl_theme_setting_export/view/detail/window.js'
            );
            $view->extendsTemplate(
                'backend/theme/simkl_theme_setting_export/controller/detail.js'
            );
        }
    }

}