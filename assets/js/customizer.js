/**
 * Customizer Live Preview
 *
 * Used for generating the live preview without the need to refresh the
 * whole page.
 *
 * @package   infopreneur
 * @copyright Copyright (c) 2016, Nose Graze Ltd.
 * @license   GPL2+
 */

(function ($) {

    var currentTime = new Date();

    // Header image
    wp.customize('header_image', function (value) {
        value.bind(function (to) {
            var banner = $('#site-banner');

            // Check if we're removing the image.
            if (to == 'remove-header') {
                banner.remove();

                return;
            }

            if (banner.length > 0) {
                banner.find('img').attr('src', to);
            } else {
                $('.site-branding').prepend('<a href="' + '" rel="home" id="site-banner"><img src="' + to + '" alt=""></a>');
            }
        });
    });

    // Site title and description.
    wp.customize('blogname', function (value) {
        value.bind(function (to) {
            $('.site-title a').text(to);
        });
    });
    wp.customize('blogdescription', function (value) {
        value.bind(function (to) {
            $('.site-description').text(to);
        });
    });

    // Header text color.
    wp.customize('header_textcolor', function (value) {
        value.bind(function (to) {
            if ('blank' === to) {
                $('.site-title a, .site-description').css({
                    'clip': 'rect(1px, 1px, 1px, 1px)',
                    'position': 'absolute'
                });
            } else {
                $('.site-title a, .site-description').css({
                    'clip': 'auto',
                    'position': 'relative',
                });

                $('.site-title a').css('color', to);
            }
        });
    });

    // Top Bar BG
    wp.customize('top_bar_bg', function (value) {
        value.bind(function (to) {
            $('#top-bar, #top-bar .navigation ul ul').css('background-color', to);
        });
    });

    // Top Bar Text Colour
    wp.customize('top_bar_color', function (value) {
        value.bind(function (to) {
            $('#top-bar a').css('color', to);
        });
    });

    // Sticky Menu
    wp.customize('sticky_menu', function (value) {
        value.bind(function (to) {
            if (to) {
                $('body').addClass('sticky-menu');
            } else {
                $('body').removeClass('sticky-menu');
            }
        });
    });

    // Layout Width
    wp.customize('max_width', function (value) {
        value.bind(function (to) {
            $('.container').css({
                'max-width': to + 'px'
            });
        });
    });

    // Container Style
    wp.customize('layout_style', function (value) {
        value.bind(function (to) {
            $('body').removeClass('layout-style-full layout-style-boxed').addClass('layout-style-' + to);
        });
    });

    // Featured - show/hide
    var featuredMods = ['show_featured_blog', 'show_featured_single', 'show_featured_page'];
    $.each(featuredMods, function (index, modName) {
        wp.customize(modName, function (value) {
            value.bind(function (to) {
                if (to) {
                    $('#featured-area').show();
                } else {
                    $('#featured-area').hide();
                }
            });
        });
    });

    // Featured - alignment
    wp.customize('featured_alignment', function (value) {
        value.bind(function (to) {
            $('#featured-area').removeClass('featured-centered featured-left featured-right').addClass(to);
        });
    });

    // Featured - BG color
    wp.customize('featured_bg_color', function (value) {
        value.bind(function (to) {
            $('#featured-area').css('background-color', to);
        });
    });

    // Featured - BG image
    wp.customize('featured_bg_image', function (value) {
        value.bind(function (to) {
            $('#featured-area').css('background-image', 'url(' + to + ')');
        });
    });

    // Featured - BG position
    wp.customize('featured_bg_position', function (value) {
        value.bind(function (to) {
            $('#featured-area').css('background-position', to.replace('-', ' '));
        });
    });

    // Featured - text colour
    wp.customize('featured_text_color', function (value) {
        value.bind(function (to) {
            $('#featured-area').css('color', to);
        });
    });

    // Featured - Heading
    wp.customize('featured_heading', function (value) {
        value.bind(function (to) {
            $('#featured-heading').text(to);
        });
    });

    // Featured - Desc
    wp.customize('featured_desc', function (value) {
        value.bind(function (to) {
            $('#featured-desc').html(to);
        });
    });

    // Featured - URL
    wp.customize('featured_url', function (value) {
        value.bind(function (to) {
            $('#featured-cta a').attr('href', to);
        });
    });

    // Featured - Button Text
    wp.customize('featured_button', function (value) {
        value.bind(function (to) {
            $('#featured-cta a').text(to);
        });
    });

    // Featured - Button BG
    wp.customize('featured_button_bg_color', function (value) {
        value.bind(function (to) {
            $('#featured-cta a').css({
                'background-color': to,
                'border-color': to,
                'border-bottom-color': shadeColor(to, -0.2)
            });
        });
    });

    // Featured - Button Text
    wp.customize('featured_button_text_color', function (value) {
        value.bind(function (to) {
            $('#featured-cta a').css('color', to);
        });
    });

    // Post Layout
    wp.customize('post_layout', function (value) {
        value.bind(function (to) {
            $('#post-feed').attr('class', 'layout-' + to);
        });
    });

    // Thumbnail Alignment
    wp.customize('thumbnail_align', function (value) {
        value.bind(function (to) {
            var maxWidth = '100%';

            if (to == 'alignleft' || to == 'alignright') {
                maxWidth = '200px';
            }

            $('.post-thumbnail').removeClass('aligncenter alignleft alignright').addClass(to).css('max-width', maxWidth);
        });
    });

    // EDD - Page Title
    wp.customize('edd_page_title', function (value) {
        value.bind(function (to) {
            $('.post-type-archive-download .page-title').text(to);
        });
    });

    // EDD - Page Desc
    wp.customize('edd_page_desc', function (value) {
        value.bind(function (to) {
            $('.post-type-archive-download .archive-description').html(to);
        });
    });

    // Portfolio - Page Title
    wp.customize('portfolio_page_title', function (value) {
        value.bind(function (to) {
            console.log(to);
            $('.post-type-archive-jetpack-portfolio .page-title').text(to);
        });
    });

    // Portfolio - Page Desc
    wp.customize('portfolio_page_desc', function (value) {
        value.bind(function (to) {
            $('.post-type-archive-jetpack-portfolio .archive-description').html(to);
        });
    });

    // Homepage area #1
    wp.customize('home_widget_1_cols', function (value) {
        value.bind(function (to) {
            $('#home-widget-1').attr('class', 'home-widget-area widget-area home-widget-area-' + to + '-cols');
        });
    });
    // Homepage area #2
    wp.customize('home_widget_2_cols', function (value) {
        value.bind(function (to) {
            $('#home-widget-2').attr('class', 'home-widget-area widget-area home-widget-area-' + to + '-cols');
        });
    });
    // Homepage area #3
    wp.customize('home_widget_3_cols', function (value) {
        value.bind(function (to) {
            $('#home-widget-3').attr('class', 'home-widget-area widget-area home-widget-area-' + to + '-cols');
        });
    });

    // Search icon show/hide
    wp.customize('search_icon', function (value) {
        value.bind(function (to) {
            if (to) {
                $('#search-site').show();
            } else {
                $('#search-site').hide();
            }
        });
    });

    // Footer text colour
    wp.customize('footer_color', function (value) {
        value.bind(function (to) {
            $('#colophon, #colophon a').color(to);
        });
    });

    // Copyright
    wp.customize('copyright_message', function (value) {
        value.bind(function (to) {
            var newValue = to.replace('[current-year]', currentTime.getFullYear());
            $('#infopreneur-copyright').empty().append(newValue);
        });
    });

    /**
     * Shade Color
     *
     * Adjusts the brightness of a color.
     *
     * @param color Hex colour to adjust.
     * @param percent Value between -1.0 (darker) and 1.0 (lighter).
     * @returns {string}
     */
    function shadeColor(color, percent) {
        var f = parseInt(color.slice(1), 16), t = percent < 0 ? 0 : 255, p = percent < 0 ? percent * -1 : percent, R = f >> 16, G = f >> 8 & 0x00FF, B = f & 0x0000FF;
        return "#" + (0x1000000 + (Math.round((t - R) * p) + R) * 0x10000 + (Math.round((t - G) * p) + G) * 0x100 + (Math.round((t - B) * p) + B)).toString(16).slice(1);
    }

})(jQuery);