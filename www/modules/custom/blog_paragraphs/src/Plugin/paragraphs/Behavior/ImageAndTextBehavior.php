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
 *     id = "blog_paragraphs_image_and_text",
 *     label = @Translation("Settings Image and Text Paragraph."),
 *     description = @Translation("Extended settings Image and Text
 *     Paragraphs."),
 *     weight = 0,
 * )
 */
class ImageAndTextBehavior extends ParagraphsBehaviorBase {

  /**
   * {@inheritdoc}
   */
  public static function isApplicable(ParagraphsType $paragraphs_type) {
    return $paragraphs_type->id() == "image_and_text";
  }

  /**
   * Extends the paragraph render array with behavior.
   */
  public function view(array &$build, Paragraph $paragraph, EntityViewDisplayInterface $display, $view_mode) {
    // ksm($build, $paragraph, $display, $view_mode);
    $bem_block = 'paragraph-' . $paragraph->bundle() . ($view_mode == 'default' ? '' : '-' . $view_mode);
    $image_position = $paragraph->getBehaviorSetting($this->getPluginId(), 'image_position', 'left');
    $image_size = $paragraph->getBehaviorSetting($this->getPluginId(), 'image_size', '8_24');

    $build['#attributes']['class'][] = Html::getClass($bem_block . '--image-position-' . $image_position);
    $build['#attributes']['class'][] = Html::getClass($bem_block . '--image-size-' . $image_size);

    if (isset($build['field_image']) && ($build['field_image']['#formatter'] == 'image')) {
      switch ($image_size) {
        case '8_24':
        default:
          $image_style = 'paragraph_image_text_8_of_24';
          break;

        case '12_24':
          $image_style = 'paragraph_image_text_12_of_24';
          break;

        case '16_24':
          $image_style = 'paragraph_image_text_16_of_24';
          break;

        case '24_24':
          $image_style = 'paragraph_image_text_24_of_24';
          break;
      }
      $build['field_image'][0]['#image_style'] = $image_style;
    }
  }

  /**
   * {@inheritdoc}
   */
  public function buildBehaviorForm(ParagraphInterface $paragraph, array &$form, FormStateInterface $form_state) {
    $form['image_position'] = [
      '#type' => 'select',
      '#title' => $this->t('Image position.'),
      '#options' => [
        'left' => $this->t('Left position'),
        'right' => $this->t('Right position'),
      ],
      '#default_value' => $paragraph->getBehaviorSetting($this->getPluginId(), 'image_position', 'left'),
    ];
    $form['image_size'] = [
      '#type' => 'select',
      '#title' => $this->t('Image size.'),
      '#description' => $this->t('Size of the image in grid'),
      '#options' => [
        '8_24' => $this->t('8 columns of 24'),
        '12_24' => $this->t('12 columns of 24'),
        '16_24' => $this->t('16 columns of 24'),
        '24_24' => $this->t('24 columns of 24'),
      ],
      '#default_value' => $paragraph->getBehaviorSetting($this->getPluginId(), 'image_size', '8_24'),
    ];

    return $form;
  }
}