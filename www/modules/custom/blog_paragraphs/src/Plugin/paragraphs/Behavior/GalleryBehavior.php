<?php
/**
 * Created by PhpStorm.
 * User: AID
 * Date: 20.02.2019
 * Time: 15:14
 */


namespace Drupal\blog_paragraphs\Plugin\paragraphs\Behavior;

use Drupal\Component\Utility\Html;
use Drupal\Core\Annotation\Translation;
use Drupal\Core\Entity\Display\EntityViewDisplayInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\PluralTranslatableMarkup;
use Drupal\paragraphs\Annotation\ParagraphsBehavior;
use Drupal\paragraphs\Entity\Paragraph;
use Drupal\paragraphs\Entity\ParagraphsType;
use Drupal\paragraphs\ParagraphInterface;
use Drupal\paragraphs\ParagraphsBehaviorBase;

/**
 * @ParagraphsBehavior (
 *     id = "blog_paragraphs_gallery",
 *     label = @Translation("Settings Gallery."),
 *     description = @Translation("Extended settings Photo Gallery."),
 *     weight = 0,
 * )
 */
class GalleryBehavior extends ParagraphsBehaviorBase {

    /**
     * {@inheritdoc}
     */
    public static function isApplicable(ParagraphsType $paragraphs_type)
    {
        //return parent::isApplicable($paragraphs_type);
        return $paragraphs_type->id() == "gallery";
    }

    /**
     * Extends the paragraph render array with behavior.
     */
    public function view(array &$build, Paragraph $paragraph, EntityViewDisplayInterface $display, $view_mode)
    {
        //ksm($build, $paragraph, $display, $view_mode);
        $images_per_row = $paragraph -> getBehaviorSetting($this->getPluginId(),'items_per_row', 3);
        $bem_block = 'paragraph-'.$paragraph->bundle().($view_mode=='default'? '':'-'.$view_mode);
        $build['#attributes']['class'][] = Html::getClass($bem_block.'--images-per-row-'.$images_per_row);
    }

    /**
     * {@inheritdoc}
     */
    public function buildBehaviorForm(ParagraphInterface $paragraph, array &$form, FormStateInterface $form_state)
    {
        //return parent::buildBehaviorForm($paragraph, $form, $form_state);
        $form['items_per_row'] = [
            '#type' => 'select',
            '#title' => $this->t('Number of images per row.'),
            '#options' => [
                '2' => $this->formatPlural(2,'1 image per row','@count images per row'),
                '3' => $this->formatPlural(3,'1 image per row','@count images per row'),
                '4' => $this->formatPlural(4,'1 image per row','@count images per row'),
            ],
            '#default_value' => $paragraph -> getBehaviorSetting($this->getPluginId(),'items_per_row', 3),
        ];

        return $form;
    }
}