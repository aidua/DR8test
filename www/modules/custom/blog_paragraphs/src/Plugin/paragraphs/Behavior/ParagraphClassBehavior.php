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
 *     id = "blog_paragraphs_paragraph_class",
 *     label = @Translation("Custom classes for Paragraphs."),
 *     description = @Translation("Allow to add custom classes for Paragraph."),
 *     weight = 0,
 * )
 */
class ParagraphClassBehavior extends ParagraphsBehaviorBase {

  /**
   * {@inheritdoc}
   */
  public static function isApplicable(ParagraphsType $paragraphs_type) {
    return TRUE;
  }

  /**
   * Extends the paragraph render array with behavior.
   */
  public function view(array &$build, Paragraph $paragraph, EntityViewDisplayInterface $display, $view_mode) {
    $classes_value = $paragraph->getBehaviorSetting($this->getPluginId(), 'classes', '');
    $classes = explode(' ', $classes_value);

    foreach ($classes as $class) {
      $build['#attributes']['class'][] = Html::getClass($class);
    }
  }

  /**
   * {@inheritdoc}
   */
  public function buildBehaviorForm(ParagraphInterface $paragraph, array &$form, FormStateInterface $form_state) {
    $form['classes'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Classes for paragraph styling.'),
      '#description' => $this->t('Multiple classes separated by space. Theq will be pricessed via Html::getClass.'),
      '#default_value' => $paragraph->getBehaviorSetting($this->getPluginId(), 'classes', ''),
    ];

    return $form;
  }
}