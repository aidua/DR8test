<?php
/**
 * @file
 * Contains \Drupal\hellomodule\Plugin\Block\SocButtonsBlock.
 */
namespace Drupal\hellomodule\Plugin\Block;

use Drupal\Core\Block\BlockBase;
/**
 * Provides a SocButtonsBlock.
 *
 * @Block(
 *   id = "socbuttons_block",
 *   admin_label = @Translation("Social Buttons Block"),
 *   category = @Translation("Custom HELLOmodule block")
 * )
 */
class SocButtonsBlock extends BlockBase {
    /**
     * {@inheritdoc}
     */
    public function build() {
        return array(
            '#type' => 'markup',
            '#markup' => '<a href="#" class="fa fa-facebook" title="Ми в Facebook"></a><a href="#" class="fa fa-twitter" title="Ми в Twitter"></a><a href="#" class="fa fa-youtube" title="Ми в YouTube"></a><a href="#" class="fa fa-instagram" title="Ми в Instagram"></a><a href="/rss.xml
" class="fa fa-rss" title="RSS"></a>',
        );
    }
}

