<?php
namespace Grav\Plugin;

use Grav\Common\Plugin;


class AstrobinPlugin extends Plugin
{

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'onShortcodeHandlers' => ['onShortcodeHandlers', 0],
            'onTwigTemplatePaths' => ['onTwigTemplatePaths', 0],
            'onPluginsInitialized' => ['onPluginsInitialized', 0],
        ];
    }
    
        public function onPluginsInitialized()
    {
        $this->config = $this->grav['config'];
        $this->enable([
            'onPageInitialized' => ['onPageInitialized', 0],
        ]);
    }

    /**
     * Add current directory to twig lookup paths.
     */
    public function onTwigTemplatePaths()
    {
        $this->grav['twig']->twig_paths[] = __DIR__ . '/templates';
    }

    /**
     * Initialize configuration
     */
    public function onShortcodeHandlers()
    {
        $this->grav['shortcode']->registerAllShortcodes(__DIR__.'/shortcodes');
    }
    
    public function onPageInitialized()
    {
        $this->grav['assets']->addCss('plugin://astrobin/css/astrobin.css');
    }

}
