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
                    'position': 'relative'
                });

                $('.site-title a').css('color', to);
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
            $('#featured-desc').text(to);
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
        var f=parseInt(color.slice(1),16),t=percent<0?0:255,p=percent<0?percent*-1:percent,R=f>>16,G=f>>8&0x00FF,B=f&0x0000FF;
        return "#"+(0x1000000+(Math.round((t-R)*p)+R)*0x10000+(Math.round((t-G)*p)+G)*0x100+(Math.round((t-B)*p)+B)).toString(16).slice(1);
    }

})(jQuery);