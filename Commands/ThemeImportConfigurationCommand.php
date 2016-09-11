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

namespace Shopware\SimklThemeSettingExport\Commands;

use Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Input\InputOption,
    Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Output\OutputInterface;

class ThemeImportConfigurationCommand extends Command {

    /**
     * {@inheritdoc}
     */
    protected function configure() {
        $this
            ->setName('sw:theme:import:configuration')
            ->setDescription('Imports a theme configuration')
            ->addArgument('theme', InputArgument::REQUIRED, 'theme to export', null)
            ->addArgument('shop', InputArgument::REQUIRED, 'subshop', null)
            ->addOption('file', 'f', InputOption::VALUE_REQUIRED, 'read config from file', null)
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output) {
        $contents = "";
        $theme = $this->getThemeModel($input->getArgument('theme'));
        $shop = $this->getShopModel($input->getArgument('shop'));

        if ($theme == null)
            throw new \InvalidArgumentException('invalid theme given');
        if ($shop == null)
            throw new \InvalidArgumentException('invalid shop given');


        $file = $input->getOption('file');
        if ($file) {
            $contents = $this->getContentsFromFile($file);
        }
        else {
            // allows the user to pipe the configuration
            while (!feof(STDIN)) {
                $contents .= fread(STDIN, 1024);
            }
        }
        
        $this->getService()->setThemeSettingsArray($theme,$shop,unserialize($contents));
    }

    /**
     * returns contents of file
     * @param  String $file file path
     * @return String       contents
     */
    private function getContentsFromFile($file) {
        if (!file_exists($file))
            throw new \InvalidArgumentException("file not found");

        return file_get_contents($file);
    }
}