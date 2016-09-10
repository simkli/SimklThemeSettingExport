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

class ThemeExportConfigurationCommand extends Command {

    /**
     * {@inheritdoc}
     */
    protected function configure() {
        $this
            ->setName('sw:theme:export:configuration')
            ->setDescription('Outputs a theme configuration')
            ->addArgument('theme', InputArgument::REQUIRED, 'Theme', null)
            ->addArgument('shop', InputArgument::REQUIRED, 'Subshop', null)
            ->addOption('output', null, InputOption::VALUE_REQUIRED, 'configuration will be written to the given file', null)
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output) {
        $contents = "";
        $theme = $this->getThemeModel($input->getArgument('theme'));
        $shop = $this->getShopModel($input->getArgument('shop'));
        $file = $input->getOption('output');

        if ($theme == null)
            throw new \InvalidArgumentException('invalid theme given');
        if ($shop == null)
            throw new \InvalidArgumentException('invalid shop given');

        $settings = serialize($this->getService()->getThemeSettingsArray($theme,$shop));
        if ($file) {
            file_put_contents($file, $settings);
        }
        else {
            $output->writeln($settings);
        }

    }
}
