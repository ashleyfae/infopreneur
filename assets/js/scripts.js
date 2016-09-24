(function ($) {

    var Infopreneur = {

        /**
         * Initialize Triggers
         */
        init: function () {
            $('.layout-toggle')
                .on('click', this.toggleArea);
        },

        /**
         * Toggle Area
         * @param e
         */
        toggleArea: function (e) {
            e.preventDefault();

            // Area is currently hidden, let's reveal it.
            if ($(this).attr('aria-expanded') == 'false') {

                $(this).attr('aria-expanded', 'true');
                $(this).next().addClass('toggled');


            } else {

                // Menu is open, let's close it.
                $(this).attr('aria-expanded', 'false');
                $(this).next().removeClass('toggled');

            }
        }

    };

    Infopreneur.init();

})(jQuery);