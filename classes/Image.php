<?php

namespace Grav\Plugin\Astrobin;

use Grav\Common\Grav;

class Image
{
    private $info;
    private $api;
    private $revisions;
    
    public function __construct($info, $api)
    {
        $this->grav = Grav::instance();
        $this->info = $info;
        $this->api = $api;
        $this->revisions = [$info];
        foreach($this->info->revisions as $revision) {
            $revision_obj = $api->request($revision, [], false);
            array_push($this->revisions, $revision_obj);
        }
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
    
    public function url($format, $revision_type="final", $animated=false) {
        $revision_obj = NULL;
        if($revision_type == "final") {
            foreach($this->revisions as $revision) {
                if($revision->is_final) {
                    $revision_obj = $revision;
                }
            }
        } else if($revision_type == "original") {
            $revision_obj = $this->revisions[0];
        } else {
            $this->grav['debugger']->addMessage('Searching for revision: `' . $revision_type . '`');
            $revision_uri = '/' . $this->info->id . '/' . $revision_type . '/';
            foreach($this->revisions as $revision) {
                $this->grav['debugger']->addMessage(' - Revision: ');
                $this->grav['debugger']->addMessage($revision);
                if(property_exists($revision, 'label')) {
                    $this->grav['debugger']->addMessage('Revision label: ' . $revision->label);
                    $revision_obj = $revision;
                    break;

                }
            }
            if(is_null($revision_obj)) {
                $revision_obj = $this->revisions[0];
            }
        }
        $url = $revision_obj->{'url_' . $format};
        if($animated) {
            $url .= '?animated';
        }
        return $url; 
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
 
