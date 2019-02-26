<?php
/**
 * Created by PhpStorm.
 * User: AID
 * Date: 10.01.2019
 * Time: 23:29
 *
 * Implement hook_foorm_FORM_ID_alter()
 */
function first_theme_form_system_theme_settings_alter(&$form, &$form_state) {
    $form['my_text'] = [
        '#type' => 'textfield',
        '#title' => t('My text'),
        '#description' => t('My first settings field'),
        '#default_value' => theme_get_setting('my_text'),
    ];

}