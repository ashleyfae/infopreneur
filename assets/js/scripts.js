(function ($) {

    var Infopreneur = {

        /**
         * Initialize Triggers
         */
        init: function () {
            $('.layout-toggle')
                .on('click', this.toggleArea);

            $('#search-site')
                .on('click', 'a', this.toggleSearch);

            $('#search-wrap-close')
                .on('click', this.toggleSearch);

            $(document)
                .on('keyup', this.closeSearch);
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
        },

        /**
         * Open/Close Search
         *
         * @param e
         */
        toggleSearch: function (e) {
            e.preventDefault();

            $('#search-wrap').toggle();
        },

        closeSearch: function (e) {
            if (e.keyCode != 27) {
                return;
            }

            var searchWrap = $('#search-wrap');

            if (searchWrap.css('display') == 'block') {
                searchWrap.hide();
            }
        }

    };

    Infopreneur.init();

})(jQuery);