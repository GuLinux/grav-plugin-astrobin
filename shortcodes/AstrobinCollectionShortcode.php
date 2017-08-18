<?php

namespace Grav\Plugin\Shortcodes;
require_once(__DIR__.'/../classes/AstrobinCommons.php');
use Grav\Plugin\Astrobin\AstrobinCommons;
use Grav\Common\Utils;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;
use Grav\Plugin\Astrobin\AstrobinAPI;
use Grav\Plugin\Astrobin\AstrobinAPIException;
use Grav\Plugin\Astrobin\Collection;

class AstrobinCollectionShortcode extends Shortcode
{
    public function init()
    {
        $this->shortcode->getHandlers()->add('astrobin-collection', function(ShortcodeInterface $sc) {
            $content = $sc->getContent();
            $id = $sc->getParameter('id', '');
            $api = new AstrobinAPI();
            $params = array_merge(AstrobinCommons::defaultParams(), $sc->getParameters());
            try {
                $collection = $api->collection($id, $params );
                $output = $this->twig->processTemplate('partials/astrobin-collection.html.twig', [
                    'collection' => $collection,
                    'params' => $params,
                ]);

                return $output;
            } catch(AstrobinAPIException $e) {
                return $e->getMessage();
            }
        });
    }
}
