(function ($) {


    $(window).load(function () {
        console.log(jQuery('a[data-setting-id]').length);

        $('a[data-setting-id]').each(function () {

            $(this).on('click', function (e) {

                $('#form-heading').find('.mode').text('Update');

                e.preventDefault();

                var settingId = $(this).attr('data-setting-id');
                var $form = $('#setting_options');

                console.log(settingId);

                $('#setting_id').val(settingId);
                $('#setting_name').val($(this).text());

                var settingValues = $('#setting-' + settingId).find('.setting-values');

                var langRows = settingValues.find('tr');
                var $langs = [];

                console.log('$(this).attr(\'data-lang\')', $(this).attr('data-lang'));


                langRows.each(function () {

                    if ($(this).attr('data-lang')) {
                        $langs.push($(this).attr('data-lang'));
                        $('#setting_value_' + $(this).attr('data-lang')).val($(this).find('.setting_value_holder').val());
                    }
                    /* Else... only one language... */

                });


                $('body, html').animate({scrollTop: $('#form-heading').offset().top + 'px'}, 1500);


            })

        });


        /* On form reset */


        $('#setting_options').on('reset', function (e) {

            console.log('reset');

            $('#form-heading').find('.mode').text('Create');
            $('#setting_id').val('')


        })
    })


})(jQuery);
