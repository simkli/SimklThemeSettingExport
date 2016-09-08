/**
 * Import / export plugin for theme configurations
 *
 * @category   Shopware
 * @package    Shopware\Plugins\SimklThemeSettingExport
 * @author     Simon Klimek <me@simonklimek.de>
 * @copyright  2015 Simon Klimek ( http://simonklimek.de )
 * @license    http://www.gnu.org/licenses/agpl-3.0.en.html GNU AFFERO GENERAL PUBLIC LICENSE
 */
//{namespace name=backend/theme/main}
//{block name="backend/theme/controller/detail" append}
Ext.define('Shopware.apps.Theme.skwdThemeSettingExport.controller.Detail', {
    override: 'Shopware.apps.Theme.controller.Detail',

    init: function () {
        var me = this;

        me.callParent(arguments);

        me.control({
            'theme-detail-window': {
                'export-import-config': me.onExportImportConfig
            },
            'theme-export-window': {
                'import-config': me.onImportConfig
            }
        });
    },

    /**
     * event listener which gets called when the user clicks
     * on the "import/export" button in the theme configuration window
     * @param  formPanel    formPanel of the current theme
     * @param  theme        the current theme being edited
     * @param  shop         the current shop
     */
    onExportImportConfig: function(formPanel,theme,shop) {
        var me = this,
            values = formPanel.getForm().getValues();


        var exportWindow = Ext.create('Shopware.apps.Theme.skwdThemeSettingExport.view.export.Window', {
            exportJson: Ext.JSON.encode(values),
            formPanel: formPanel,
            theme: theme,
            shop: shop
        }).show();
    },

    /**
     * gets called when the user clicks on the import button of the
     * export/window
     * 
     * @param  window       export/window instance
     * @param  formPanel    formPanel of the current theme
     * @param  values       String which shall be imported
     */
    onImportConfig: function(window, formPanel, values) {
        var me = this;
        try {
            var values = Ext.JSON.decode(values);
            formPanel.getForm().setValues(values);
        } catch (exp) {
            Shopware.Notification.createGrowlMessage(
                '{s name="application"}Theme manager{/s}',
                exp.message,
                'Theme manager'
            );
            return;
        }
        Shopware.Notification.createGrowlMessage(
            '{s name="application"}Theme manager{/s}',
            '{s name="import_message"}Theme configuration imported{/s}',
            'Theme manager'
        );
        window.destroy();
    }

});

//{/block}