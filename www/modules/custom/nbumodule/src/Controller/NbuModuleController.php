<?php
/**
 * @file
 * Contains \Drupal\nbumodule\Controller\NbuModuleController.
 * ^ Пишеться по прикладу:
 *  - \Drupal - вказуэ що цей файл належить до ядра Drupal, тому що там ще є Symfony.
 *  - nbumodule - назва модуля.
 *  - Controller - тип файла. Папка src НЕ вказується завжди.
 *  - NbuModuleController - назва нашого класу.
 */

/**
 * Простір імен нашого контролера. Подібне на опис вище, але НЕ вказується назва нашого класу.
 */
namespace Drupal\nbumodule\Controller;

/**
 * Використовуємо клас з друпалу: ControllerBase. Наслідуємось від нього і він зробить за нас
 * всі обовязкові речі, які роблять контроллери.
 */
use Drupal\Core\Controller\ControllerBase;

/**
 * Оголошуємо наш клас-контроллер.
 */
class NbuModuleController extends ControllerBase {

    public function nbuModule() {
        $output = array();
        $output['#title'] = 'Офіційний курс валют НБУ';
        $output['#markup'] = 'NBU Hello World Module!';
        $output['#theme'] = 'nbumodule_template';
        $output['#test_var'] = 'Test Value from NBU function CONTENT';




        return $output;
    }

}

