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
 *     id = "blog_paragraphs_paragraph_style",
 *     label = @Translation("Paragraph styles."),
 *     description = @Translation("Allow to select special style for Paragraph."),
 *     weight = 0,
 * )
 */
class ParagraphStyleBehavior extends ParagraphsBehaviorBase {

    /**
     * {@inheritdoc}
     */
    public static function isApplicable(ParagraphsType $paragraphs_type)
    {
        return TRUE;
    }

    /**
     * Extends the paragraph render array with behavior.
     */
    public function view(array &$build, Paragraph $paragraph, EntityViewDisplayInterface $display, $view_mode)
    {
        //var_dump($paragraph -> getBehaviorSetting($this->getPluginId(),'styles', []));
        $bem_block = 'paragraph-'.$paragraph->bundle().($view_mode=='default'? '':'-'.$view_mode);
        $selected_styles = $paragraph -> getBehaviorSetting($this->getPluginId(),'styles', []);

        foreach ($selected_styles as $style) {
            $build['#attributes']['class'][] = $bem_block .'--'. Html::getClass($style);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function buildBehaviorForm(ParagraphInterface $paragraph, array &$form, FormStateInterface $form_state)
    {
        $form['style_wrapper'] = [
            '#type' => 'details',
            '#title' => $this->t('Paragraphs styles.'),
            '#open' => FALSE,
            '#weight' => 100,
        ];

        $styles = $this->getStyles($paragraph);
        $selected_styles = $paragraph -> getBehaviorSetting($this->getPluginId(),'styles', []);

        foreach ($styles as $group_id => $group) {
            $form['style_wrapper'][$group_id] = [
                '#type' => 'checkboxes',
                '#title' => $group['label'],
                '#options' => $group['options'],
                '#default_value' => $selected_styles,
            ];
        }

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function submitBehaviorForm(ParagraphInterface $paragraph, array &$form, FormStateInterface $form_state)
    {
        //parent::submitBehaviorForm($paragraph, $form, $form_state);
        $styles = [];
        $filtered_values = $this->filterBehaviorFormSubmitValues($paragraph,$form, $form_state);

        if (isset($filtered_values['style_wrapper'])) {
            $style_groups = $filtered_values['style_wrapper'];

            foreach ($style_groups as $group) {
                foreach ($group as $style_name) {
                    $styles[] = $style_name;
                }
            }

            $paragraph->setBehaviorSettings($this->getPluginId(), ['styles' => $styles]);
        }
    }

    /**
     * Return styles for paragraph.
     */
    public function getStyles (ParagraphInterface $paragraph) {
        $style = [];
        if ($paragraph->hasField('field_title')) {
            $style['title'] = [
                'label' => $this->t('Paragraphs title:'),
                'options' => [
                    'title_bold' => $this->t('Bold'),
                    'title_centered' => $this->t('Centered'),
                ],
            ];
        }

        $style['common'] = [
            'label' => $this->t('Paragraph common styles:'),
            'options' => [
                'style_black' => $this->t('Style black'),
            ],
        ];

        return $style;
    }
}