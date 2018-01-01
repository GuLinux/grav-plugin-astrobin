<?php

namespace Grav\Plugin\Astrobin;
require_once(__DIR__.'/Image.php');
require_once(__DIR__.'/Collection.php');

use Grav\Common\Grav;
use Grav\Plugin\Astrobin\Collection;

use Grav\Common\GPM\Response;
use Grav\Common\Cache;

class AstrobinAPIException extends \Exception {
    public function __construct($obj)
    {
        parent::__construct("Error during Astrobin API call with code " . $obj['code'] . ": " . $obj['message'], $obj['code'], null);
    }
}

class AstrobinAPI
{
    protected $key;
    protected $secret;
    protected $user_id;
    protected $grav;
    protected $config;
    protected $cache;
    protected $cache_duration;

    /**
     * set some instance variable states
     */
    public function __construct()
    {
        $this->grav = Grav::instance();
        $this->config = $this->grav['config'];
        $this->key = $this->config->get('plugins.astrobin.astrobin_api_key');
        $this->secret = $this->config->get('plugins.astrobin.astrobin_api_secret');        
        $this->cache_duration = $this->config->get('plugins.astrobin.astrobin_cache_duration');        
        $this->cache = new Cache($this->grav);
    }
    
    public function image($id)
    {
        return $this->image_by_uri("/image/" . $id . "/");
    }

    public function image_by_uri($uri, $has_prefix = false)
    {
        try {
            $info = $this->request($uri, [], ! $has_prefix);
            if($info != NULL)
                return new Image($info, $this);
        } catch(RuntimeException $e) {
            $grav['debugger']->addMessage("Error while getting image by uri " . $uri . ": " . $e);
        }
        return NULL;
    }
    
    public function collection($id)
    {
        $info = $this->request( '/collection/' . $id . '/');
        if($info != NULL)
            return new Collection($info, $this);
        return NULL;
    }
    
    public function request($path, $params = [], $add_prefix = true) {
        $prefix = '';
        if($add_prefix)
            $prefix = '/api/v1';
        
        $url = 'https://www.astrobin.com' . $prefix . $path . "?" . http_build_query(array_merge($params, ['api_key' => $this->key, 'format' => 'json', 'api_secret' => $this->secret]));
        if($this->cache_duration > 0) {
            $obj = $this->cache->fetch($url);
            if($obj) {
                return $obj;
            }
        }
        try {
            $response = Response::get($url);
            $obj = json_decode($response);
            if($this->cache_duration > 0) {
                $this->cache->save($url, $obj, $this->cache_duration);
            }
            return $obj;
        } catch(Exception $e) {
            throw new AstrobinAPIException($e);
        }
    }
}

