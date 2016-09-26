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

    var frontPageDisplay = $('#customize-control-show_on_front');
    var staticPageOpts = $('#customize-control-show_featured_home, #customize-control-show_below_header_widget_area');

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