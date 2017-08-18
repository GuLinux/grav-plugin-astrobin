<?php

namespace Grav\Plugin\Astrobin;

use Grav\Common\Grav;

class Image
{
    private $info;
    
    public function __construct($info)
    {
        $this->info = $info;
    }
    
    public function id() {
        return $this->info->id;
    }

    public function title() {
        return $this->info->title;
    }
    
    public function datetaken() {
        // TODO: to be retrieved in astrobin from acquisition details
        return NULL;
    }
    
    public function url($format) {
        return $this->info->{'url_' . $format};
    }
    
    public function astrobinPage() {
        return 'https://www.astrobin.com/' . $this->info->id;
    }
    
    public function description() {
        return $this->info->description;
    }
    
    private function username() {
        return $this->info->user;
    }
}
 
