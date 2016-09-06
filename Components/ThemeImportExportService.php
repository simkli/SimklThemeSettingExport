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

namespace Shopware\SimklThemeSettingExport\Components;

class ThemeImportExportService {

    private $em = null;

    function __construct($em) {
        $this->em = $em;
    }

    public function getThemeSettingsArray($theme,$shop) {
        $settings = $this->getThemeArray($theme,$shop);

        if ($settings === null) return null;

        $return = [];
        foreach ($settings as $element) {
            $name = $element['name'];
            $value = $element['defaultValue'];
            if (!empty($element['values'])) {
                $value = $element['values'][0]['value'];
            }
            $return[$name] = $value;
        }
        return $return;
    }

    public function getThemeArray($theme,$shop) {
        $repository = $this->em->getRepository('Shopware\Models\Shop\Template');
        $quB = $repository->createQueryBuilder('template');

        $quB->select(['template','elements', 'values'])
            ->leftJoin('template.elements','elements')
            ->leftJoin('elements.values','values','WITH','values.shop = :shop')
            ->andWhere('template = :theme')
            ->setParameter('shop',$shop)
            ->setParameter('theme',$theme);
            
        $query = $quB->getQuery();
        $template = $query->getOneOrNullResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        return $template === null ? null : $template['elements'];
    }

    /**
     * TODO
     */
    public function setThemeSettingsArray($theme,$shop,$settings) {

    }

    /**
     * TODO
     */
    public function setThemeSetting($theme,$name,$value,$shop = null) {

    }

}