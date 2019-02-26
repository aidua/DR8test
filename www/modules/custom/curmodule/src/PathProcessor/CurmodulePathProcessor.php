<?php
/**
 * @file
 * Contains \Drupal\curmodule\PathProcessor\CurModuleController.
 * ^ Пишеться по прикладу:
 *  - \Drupal - вказуэ що цей файл належить до ядра Drupal, тому що там ще є Symfony.
 *  - curmodule - назва модуля.
 *  - Controller - тип файла. Папка src НЕ вказується завжди.
 *  - CurModuleController - назва нашого класу.
 */

namespace Drupal\curmodule\PathProcessor;

use Drupal\Core\PathProcessor\InboundPathProcessorInterface;
use Symfony\Component\HttpFoundation\Request;

class CurmodulePathProcessor implements InboundPathProcessorInterface {

    public function processInbound($path, Request $request) {
        if (strpos($path, '/currencies/') === 0) {
            $names = preg_replace('|^\/currencies\/|', '', $path);
            $names = str_replace('/',':', $names);
            return "/currencies/$names";
        }
        return $path;
    }

}