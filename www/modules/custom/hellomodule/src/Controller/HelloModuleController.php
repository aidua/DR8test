<?php
/**
 * @file
 * Contains \Drupal\hellomodule\Controller\HelloModuleController.
 * ^ Пишеться по прикладу:
 *  - \Drupal - вказуэ що цей файл належить до ядра Drupal, тому що там ще є Symfony.
 *  - hellomodule - назва модуля.
 *  - Controller - тип файла. Папка src НЕ вказується завжди.
 *  - HelloModuleController - назва нашого класу.
 */

/**
 * Простір імен нашого контролера. Подібне на опис вище, але НЕ вказується назва нашого класу.
 */
namespace Drupal\hellomodule\Controller;

/**
 * Використовуємо клас з друпалу: ControllerBase. Наслідуємось від нього і він зробить за нас
 * всі обовязкові речі, які роблять контроллери.
 */
use Drupal\Core\Controller\ControllerBase;

/**
 * Оголошуємо наш клас-контроллер.
 */
class HelloModuleController extends ControllerBase {

    /**
     * {@inheritdoc}
     * В Drupal 8 дуже багато будується на renderable arrays и при поверненні даною функцією
     * вмісту сторінки, ми також повинні вернути масив, який спокійно пройде через drupal_render().
     */
    public function helloModule() {
        $output = array();
        $output['#title'] = 'HelloModule page title';
        $output['#markup'] = 'Hello World Module!';
        $output['#theme'] = 'hellomodule_template';
        $output['#test_var'] = 'Test Value from function CONTENT';
        return $output;
    }

}

