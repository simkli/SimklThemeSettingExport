# Theme Config Im-/Export Plugin
This plugin allows you to import or export theme configurations in [Shopware 5](https://github.com/shopware/shopware).

## Installation
The easiest way to install this plugin is by downloading the latest release. You can upload the .zip file in the Shopware Plugin Manager. ( Configuration > Plugin Manager > Installed > Upload Plugin )

#####[Downloads](https://github.com/simkli/SimklThemeSettingExport/releases)
### Commandline
1) Clone this repository into the `/engine/Shopware/Plugins/Community/Backend` directory using the following command:
```
git clone https://github.com/simkli/SimklThemeSettingExport.git
```
2) Log in to your Shopware backend and activate the plugin in the Shopware Plugin Manager.

## Usage
You'll find a new button in the theme configuration menu called "Ex/Import". This will open a new window containing a json string of your current theme configuration. You can copy&past this string to any other theme installed to inherit the current configuration.

![Image](https://dl.dropboxusercontent.com/u/2419584/things/themeplugin.png)
## License
This plugin is distributed under the GNU Affero General Public License v3.
