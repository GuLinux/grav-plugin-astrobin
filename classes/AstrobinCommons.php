<?php
namespace Grav\Plugin\Astrobin;
require_once(__DIR__.'/AstrobinAPI.php');

class AstrobinCommons {
    static function defaultParams() {
      return [
        'format_image' => 'regular',
        'format_image_lightbox' => 'hd',
        'collection_title_tag' => 'h3',
        'collection_description_tag' => 'h5',
        'revision' => 'final'
      ];
    }
}
