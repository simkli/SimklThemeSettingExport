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
//{block name="backend/theme/simkl_theme_setting_export/view/export/window"}
/**
 * window of the import / export ExtJS app
 */
Ext.define('Shopware.apps.Theme.skwdThemeSettingExport.view.export.Window', {
    extend: 'Enlight.app.Window',
    alias: 'widget.theme-export-window',
    title : '{s name=exportWindowTitle}Export / Import{/s}',
    width: 480,
    height: 250,
    layout:'fit',
    exportJson: 'test',
    formPanel: null,
    modal: true,
    resizeable: false,
    minimizable: false,
    maximizable: false,

    initComponent: function() {
        var me = this;

        me.items = me.createItems();

        me.callParent(arguments);
    },

    /**
     * The main window contains one tab panel.
     * This will be created by this function
     * @return { [Ext.tab.Panel] }
     */
    createItems: function() {
        var me = this;

        return Ext.create('Ext.tab.Panel', {
            layout:'fit',
            items: [
                me.createExportFieldset(),
                me.createImportFieldset()
            ]
        });
    },

    /**
     * Creates the export form panel including a textarea which 
     * contains the export json string
     * @return { Ext.form.Panel }
     */
    createExportFieldset: function() {
        var me = this;
        return Ext.create('Ext.form.Panel', {
            layout: 'fit',
            title: '{s name=exportTitle}Export{/s}',
            items: [
                {
                    xtype: 'fieldset',
                    border: false,
                    layout: {
                        type: 'vbox',
                        align : 'stretch'
                    },
                    items: [
                        {
                            xtype: 'label',
                            text: '{s name=exportInfo}The following json string contains your current theme configuration. You can paste this json string into the import tab of another theme to copy your current theme configuration.{/s}',
                            flex:1
                        },
                        {
                            xtype: 'splitter',
                        },
                        {
                            xtype: 'textarea',
                            value: me.exportJson,
                            fieldStyle: 'white-space: pre',
                            flex:2,
                            readOnly: true
                        }
                    ]
                }
            ],

        });
    },

    /**
     * Creates the import form panel. This includes a textarea
     * field to enter a json string and adds an import button
     * to the bottom bar
     * @return { Ext.form.Panel }
     */
    createImportFieldset: function() {
        var me = this;
        return Ext.create('Ext.form.Panel', {
            layout: 'fit',
            title: '{s name=importTitle}Import{/s}',
            items: [
                {
                    xtype: 'fieldset',
                    border: false,
                    layout: {
                        type: 'vbox',
                        align : 'stretch'
                    },
                    items: [
                        me.createImportField()
                    ]
                }
            ],
            bbar: [
                { xtype: 'tbfill' },
                me.createImportButton()
            ]

        });
    },

    /**
     * Creates a textarea field used by createImportFieldset
     * @return { Ext.form.field.TextArea }
     */
    createImportField: function() {
        var me = this;

        me.importField = Ext.create('Ext.form.field.TextArea', {
            xtype: 'textarea',
            value: '',
            flex:1,
            fieldStyle: 'white-space: pre',
        });

        return me.importField;
    },

    /**
     * Creates an import button used by createImportFieldset
     * @return { Ext.button.Button }
     */
    createImportButton: function () {
        var me = this;

        me.importButton = Ext.create('Ext.button.Button', {
            cls: 'primary',
            name: 'export-import-button',
            text: '{s name=importConfig}Import{/s}',
            handler: function () {
                me.fireEvent(
                    'import-config',
                    me,
                    me.formPanel,
                    me.importField.getValue()
                );
            }
        });
        return me.importButton;
    }
});
//{/block}