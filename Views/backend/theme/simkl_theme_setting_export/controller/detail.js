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
                'export-import-config': me.onOpenExportWindow
            },
            'theme-export-window': {
                'export-theme-settings': me.onExportConfig
            }
            // TODO 
            // import handler
        });
    },

    /**
     * event listener which gets called when the user clicks
     * on the "import/export" button in the theme configuration window
     * @param  formPanel    formPanel of the current theme
     * @param  theme        the current theme being edited
     * @param  shop         the current shop
     */
    onOpenExportWindow: function(formPanel,theme,shop) {
        var me = this,
            values = formPanel.getForm().getValues();


        var exportWindow = Ext.create('Shopware.apps.Theme.skwdThemeSettingExport.view.export.Window', {
            exportJson: Ext.JSON.encode(values),
            formPanel: formPanel,
            theme: theme,
            shop: shop
        }).show();
    },

    
    
    onExportConfig: function(exportWindow, theme, shop) {
        var me = this,
            formPanel = me.getDetailWindow().formPanel;

        Ext.Msg.confirm('{s name="ExportConfirmTitle"}Export{/s}', '{s name="ExportConfirmMessage"}If you have changed the configuration you need to save it before exporting. Do you want to save it now?{/s}', function(btnText){
            if(btnText === "yes"){
                me.saveConfigExport(theme,shop,formPanel);
            }
            else {
                me.downloadExport();   
            }
        }, me);
        
    },

    saveConfigExport: function(theme, shop, formPanel) {
        var me = this;
                            
        theme = me.updateShopValues(
            theme,
            shop,
            formPanel.getForm().getFields(),
            formPanel.getForm().getValues()
        );
        theme.save({
            callback: function() {
                Shopware.Notification.createGrowlMessage(
                    '{s name="application"}Theme manager{/s}',
                    '{s name="save_message"}Theme configuration saved{/s}',
                    'Theme manager'
                );
                me.downloadExport();
            }
        });
    },

    downloadExport: function(theme,shop) {
        var url = '{url controller="ThemeImportExport" action="export"}?theme=' + theme.getId() + '&shop=' + shop.getId();
        window.location.href=url;
    }

});

//{/block}