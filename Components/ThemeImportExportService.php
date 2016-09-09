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

use \Doctrine\Common\Collections\Collection,
    Shopware\Models\Shop\Shop,
    Shopware\Models\Shop\Template,
    Shopware\Models\Shop\TemplateConfig\Element,
    Shopware\Models\Shop\TemplateConfig\Value;

class ThemeImportExportService {

    private $em = null;

    function __construct($em) {
        $this->em = $em;
    }

    public function getThemeSettingsArray(Template $theme, Shop $shop) {
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

    /**
     * @param  Template $theme [description]
     * @param  Shop     $shop  [description]
     * @return [type]          [description]
     */
    public function getThemeArray(Template $theme, Shop $shop) {
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
     * 
     * @param Template $theme    [description]
     * @param Shop     $shop     [description]
     * @param array    $settings [description]
     */
    public function setThemeSettingsArray(Template $theme, Shop $shop, array $settings) {
        $elements = $theme->getElements();
        $elements = $this->buildKeyValueSettings($elements);

        foreach ($settings as $key => $value) {
            if (!isset($elements[$key])){
                continue;
            }
            $element = $elements[$key];
            $valueEntity = $this->getValueForShop($element, $shop);
            $valueEntity->setValue($value);

        }
  
        $this->em->flush();
    }


    /**
     * Helper function to speed up element look up.
     * We need to iterate the collection just once
     * @param  Collection $collection theme setting elements
     * @param Shop 
     * @return array    element_name => element array
     */
    private function buildKeyValueSettings(Collection $collection, Shop $shop) {
        $return = [];
        foreach ($collection as $element) {
            $return[$element->getName()] = $element;
        }
        return $return;
    }

    /**
     * gets a subshop specific value of a settings element
     * @param  Element $element 
     * @param  Shop    $shop    
     * @return Value           
     */
    private function getValueForShop(Element $element, Shop $shop) {
        foreach ($element->getValues() as $value) {
            if ($value->getShop() == $shop) {
                return $value;
            }
        }
        $newVal = new Value();
        $newVal->setShop($shop);
        $newVal->setElement($element);
        $newVal->setValue($element->getValue());
        return $newVal;
    }

}