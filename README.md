Grav Astrobin Plugin
==================

This plugin allows you to fetch astrobin images and collections, and display them in page.

The current template make use of `featherlight`, with the `gallery` option enabled, to open your images in a slideshow.
If you wish to change this behaviour, please modify templates in the `templates/partial` directory.

Astrobin data is provided via shortcodes, the `shortcode-core` plugin is therefore another dependency.

Quick usage
-----------

First you must configure your Astrobin account, getting an API key and secret. Just click on your username on the right, and in the menu select "API Keys", then request a new key if you don't already have one.

Configure the astrobin plugin (`astrobin.yaml` in `user/config/plugins/`, or even better using Grav Admin),  with these values:

    astrobin_api_key: "<your api key>"
    astrobin_api_secret: "<your api secret>"

To test the plugin you need to find the id of the Astrobin daya you want to display.
Currently the plugin supports single images, imagesets (albums) and collections.
The id can usually be found on the url of the resource you are currently browsing.

### Single image

    [astrobin-image id=<image-id>]

### Collections

    [astrobin-collection id=<collection-id>]
    

Advanced Options
----------------

Each shortcode accepts additional values beside the `id` parameter.
This is a list for each shortcode.

 * astrobin-image:
   * `format_image`: single letter, defining the image size to be displayed. Look [Astrobin URL reference](https://www.astrobin.com/services/api/misc.urls.html) for all possible values.
   * `format_image_lightbox`: same values as the previous parameter, but used to define image size in the lightbox popup.
   * `image_class`: extra css classes for the main image html tag.
   * `image_lightbox_class`: extra css classes for the main lightbox html tag.
   * `revision`: image revision to load. It can be "final", "original", or an uppercase letter corresponding to the revision letter of the astrobin technical page (A, B, C, etc).
 * astrobin-collection
   * `collection_title_tag`: HTML tag to use for the collection title.
   * `collection_description_tag`: HTML tag to use for the collection description.
   * `collection_class`: extra css classes for the main collection html tag.
   * All the parameters for **astrobin-image** are also supported to properly display child images.
   
Available formats in astrobin API:
 - duckduckgo
 - duckduckgo_small
 - gallery
 - hd
 - real
 - regular
 - thumb

