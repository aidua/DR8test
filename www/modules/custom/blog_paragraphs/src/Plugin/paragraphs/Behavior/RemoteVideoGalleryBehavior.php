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
 *     id = "blog_paragraphs_remote_video_gallery",
 *     label = @Translation("Remote video gallery Settings."),
 *     description = @Translation("Extended settings Remote Video Gallery."),
 *     weight = 0,
 * )
 */
class RemoteVideoGalleryBehavior extends ParagraphsBehaviorBase {

    /**
     * {@inheritdoc}
     */
    public static function isApplicable(ParagraphsType $paragraphs_type)
    {
        //return parent::isApplicable($paragraphs_type);
        return $paragraphs_type->id() == "youtube_gallery";
    }

    /**
     * Extends the paragraph render array with behavior.
     */
    public function view(array &$build, Paragraph $paragraph, EntityViewDisplayInterface $display, $view_mode)
    {
        //ksm($build, $paragraph, $display, $view_mode);
        $videos_per_row = $paragraph -> getBehaviorSetting($this->getPluginId(),'items_per_row', 3);
        $bem_block = 'paragraph-'.$paragraph->bundle().($view_mode=='default'? '':'-'.$view_mode);
        $build['#attributes']['class'][] = Html::getClass($bem_block.'--videos-per-row-'.$videos_per_row);
    }

    /**
     * {@inheritdoc}
     */
    public function buildBehaviorForm(ParagraphInterface $paragraph, array &$form, FormStateInterface $form_state)
    {
        //return parent::buildBehaviorForm($paragraph, $form, $form_state);
        $form['items_per_row'] = [
            '#type' => 'select',
            '#title' => $this->t('Number of videos per row.'),
            '#options' => [
                '2' => $this->formatPlural(2,'1 video per row','@count videos per row'),
                '3' => $this->formatPlural(3,'1 video per row','@count videos per row'),
                '4' => $this->formatPlural(4,'1 video per row','@count videos per row'),
            ],
            '#default_value' => $paragraph -> getBehaviorSetting($this->getPluginId(),'items_per_row', 3),
        ];

        return $form;
    }
}