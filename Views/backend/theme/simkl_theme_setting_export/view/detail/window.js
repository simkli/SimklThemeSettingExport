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
//{block name="backend/theme/view/detail/window" append}
Ext.define('Shopware.apps.Theme.skwdThemeSettingExport.view.Window', {
    override: 'Shopware.apps.Theme.view.detail.Window',

    /**
     * override the createToolbarItems function to add
     * a new button for our import/export module
     * @return array    bottom bar itemes of the theme configuration window
     */
    createToolbarItems: function () {
        var me = this
            result = me.callParent(arguments);

        result.unshift(me.createExportButton());

        return result;
    },

    /**
     * Creates a new button to open the import/export module
     * @return { Ext.button.Button }
     */
    createExportButton: function() {
        var me = this;

        me.exportConfigButton = Ext.create('Ext.button.Button', {
            cls: 'secondary',
            name: 'export-config-button',
            text: '{s name=export_config}Ex-/Import{/s}',
            handler: function () {
                me.fireEvent('export-import-config', me.formPanel);
            }
        });

        return me.exportConfigButton;
    }


});

//{/block}