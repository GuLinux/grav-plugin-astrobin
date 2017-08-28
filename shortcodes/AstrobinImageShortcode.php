<?php

namespace Grav\Plugin\Shortcodes;
require_once(__DIR__.'/../classes/AstrobinCommons.php');
use Grav\Plugin\Astrobin\AstrobinCommons;
use Grav\Common\Utils;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;
use Grav\Plugin\Astrobin\AstrobinAPI;
use Grav\Plugin\Astrobin\AstrobinAPIException;
//use Grav\Plugin\Astrobin\Imageset;
use Grav\Plugin\Astrobin\Image;

class AstrobinImageShortcode extends Shortcode
{
    public function init()
    {
        $this->shortcode->getHandlers()->add('astrobin-image', function(ShortcodeInterface $sc) {
            $content = $sc->getContent();
            $id = $sc->getParameter('id', '');
            $revision = $sc->getParameter('revision', '');
            $api = new AstrobinAPI();
            $params = array_merge(AstrobinCommons::defaultParams(), $sc->getParameters());
            try {
                $image = $api->image($id );
                $output = $this->twig->processTemplate('partials/astrobin-image.html.twig', [
                    'image' => $image,
                    'params' => $params,
                ]);

                return $output;
            } catch(AstrobinAPIException $e) {
                return $e->getMessage();
            }
        });
    }
}
