<?php
/**
 * @file
 * Contains \Drupal\hellomodule\Plugin\Block\hellomoduleBlock.
 */
namespace Drupal\hellomodule\Plugin\Block;

use Drupal\Core\Block\BlockBase;
/**
 * Provides a hellomoduleBlock.
 *
 * @Block(
 *   id = "hellomodule_block",
 *   admin_label = @Translation("HELLOmodule Block"),
 *   category = @Translation("Custom HELLOmodule block")
 * )
 */
class hellomoduleBlock extends BlockBase {
    /**
     * {@inheritdoc}
     */
    public function build() {
        return array(
            '#type' => 'markup',
            '#markup' => 'This custom block content.',
        );
    }
}