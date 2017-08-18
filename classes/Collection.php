<?php

namespace Grav\Plugin\Astrobin;
require_once(__DIR__.'/Image.php');
use Grav\Plugin\Astrobin\Image;

use Grav\Common\Grav;

class Collection
{
    private $info;
    private $images;
    
    public function __construct($tree, $api)
    {
        $this->info = $tree;
        $this->images = [];
        foreach($this->info->images as $image) {
            array_push($this->images, $api->image_by_uri($image, true));
        }
    }

    public function images() {
        return $this->images;
    }
    
    public function title() {
        return $this->info->name;
    }
    public function description() {
        return $this->info->description;
    }

    public function user() {
        return $this->info->user;
    }
    
}
