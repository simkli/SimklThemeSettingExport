# Theme Config Im-/Export Plugin
This plugin allows you to import or export theme configurations in [Shopware 5](https://github.com/shopware/shopware).

## Installation
The easiest way to install this plugin is by downloading the latest release. You can upload the .zip file in the Shopware Plugin Manager. ( Configuration > Plugin Manager > Installed > Upload Plugin )

###### [Downloads](https://github.com/simkli/SimklThemeSettingExport/releases)
### Commandline
1) Clone this repository into the `/engine/Shopware/Plugins/Community/Backend` directory using the following command:
```
git clone https://github.com/simkli/SimklThemeSettingExport.git
```
2) Log in to your Shopware backend and activate the plugin in the Shopware Plugin Manager.

## Usage
### Shopware Backend
This plugins extends the Shopware Theme Manager and allows you to export and import
configuration of themes.
![Image](http://i.imgur.com/YVy4qhQ.jpg)

### Via Commandline
Using the Shopware CLI you can easily import or export configurations. This can be useful
for deployment. Following commands are available:
`$ ./bin/console sw:theme:export:configuration <theme> <shop>`
`$ ./bin/console sw:theme:import:configuration <theme> <shop>`
You can use the ID or name of the shop/theme as argument.
#### Example Import
`$ ./bin/console sw:theme:import:configuration Responsive English < my_config.theme`

### For Developers
If you're plaing on releasing a theme you can use this plugin to import a example 
configuration for your customers. For example in your plugin's bootstrap:

```php
if ($this->assertRequiredPluginsPresent(['SimklThemeSettingExport']) {
    $service = $this->get('simklthemeimportexport.theme_import_export_service');
    $service->setThemeSettingsArray($yourThemeModel, $shop, [
        'brand-primary' => '#FFF',
        'brand-secondary' => '#000'
        // ...
    ]);
}
```

## License
This plugin is distributed under the GNU Affero General Public License v3.
