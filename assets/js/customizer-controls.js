/**
 * Customizer Controls
 *
 * Used for powering the conditional Customizer controls. If the "front page display"
 * is set to posts, then we need to hide all our front page controls. Otherwise we
 * need to show them.
 *
 * @package   infopreneur
 * @copyright Copyright (c) 2016, Nose Graze Ltd.
 * @license   GPL2+
 */

jQuery(document).ready(function ($) {

    /**
     * Go to URL on expanded panel.
     */
    (function (api) {

        // EDD - Archive
        api.section('edd_archive', function (section) {
            section.expanded.bind(function (isExpanded) {
                var url;
                if (isExpanded) {
                    url = api.settings.url.home + 'downloads/';
                    api.previewer.previewUrl.set(url);
                }
            });
        });

        // EDD - Single
        api.section('edd_single', function (section) {
            section.expanded.bind(function (isExpanded) {
                if (Info_Customizer.download_url) {
                    var url = Info_Customizer.download_url;
                    if (isExpanded) {
                        api.previewer.previewUrl.set(url);
                    }
                }
            });
        });

        // Portfolio - Archive
        api.section('portfolio_archive', function (section) {
            section.expanded.bind(function (isExpanded) {
                var url;
                if (isExpanded) {
                    url = api.settings.url.home + 'portfolio/';
                    api.previewer.previewUrl.set(url);
                }
            });
        });

    }(wp.customize));

    /**
     * Conditional Fields
     */
    var frontPageDisplay = $('#customize-control-show_on_front');
    var staticPageOpts = $('#customize-control-show_featured_home, #customize-control-show_below_header_widget_area, #customize-control-home_widget_1_cols, #customize-control-home_widget_2_cols, #customize-control-home_widget_3_cols');

    // On page load, show or hide our options based on the front page value.
    if (frontPageDisplay.find('input:checked').val() == 'page') {
        staticPageOpts.show();
    } else {
        staticPageOpts.hide();
    }

    frontPageDisplay.find('input').change(function () {
        if ($(this).val() == 'page') {
            staticPageOpts.show();
        } else {
            staticPageOpts.hide();
        }
    });

});