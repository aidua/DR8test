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
 *     id = "blog_paragraphs_remote_video",
 *     label = @Translation("Remote video paragraph settings."),
 *     description = @Translation("Additional settings for remote video."),
 *     weight = 0,
 * )
 */
class RemoteVideoBehavior extends ParagraphsBehaviorBase {

    /**
     * {@inheritdoc}
     */
    public static function isApplicable(ParagraphsType $paragraphs_type)
    {
        return $paragraphs_type->id() == "video_youtube";
    }

    /**
     * Extends the paragraph render array with behavior.
     */
    public function view(array &$build, Paragraph $paragraph, EntityViewDisplayInterface $display, $view_mode)
    {
        $max_video_width = $paragraph -> getBehaviorSetting($this->getPluginId(),'video_width', 'full');
        $bem_block = 'paragraph-'.$paragraph->bundle().($view_mode=='default'? '':'-'.$view_mode);

        $build['#attributes']['class'][] = Html::getClass($bem_block. '--video-width-'. $max_video_width);
    }

    /**
     * {@inheritdoc}
     */
    public function buildBehaviorForm(ParagraphInterface $paragraph, array &$form, FormStateInterface $form_state)
    {
        $form['video_width'] = [
            '#type' => 'select',
            '#title' => $this->t('Video block width.'),
            '#description' => $this->t('Maximum width for video block.'),
            '#options' => [
                'full' => '100%',
                '720p' => '720p',
                '50%' => '50%',
            ],
            '#default_value' => $paragraph -> getBehaviorSetting($this->getPluginId(),'video_width', 'full'),
       ];

        return $form;
    }
}