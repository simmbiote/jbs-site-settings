(function ($) {


    $(window).load(function () {

        $('a[data-setting-id]').each(function () {

            $(this).on('click', function (e) {

                $('#form-heading').find('.mode').text('Update');

                e.preventDefault();

                var settingId = $(this).attr('data-setting-id');
                var $form = $('#setting_options');

                $('#setting_id').val(settingId);
                $('#setting_name').val($(this).text());

                var $settingValues = $('#setting-' + settingId).find('.setting-values');

                var langRows = $settingValues.find('tr[data-lang]');
                var $langs = [];

                console.log('langRows.length', langRows.length);
                if (langRows.length > 0) {
                    langRows.each(function () {
                        if ($(this).attr('data-lang')) {
                            $langs.push($(this).attr('data-lang'));
                            $('#setting_value_' + $(this).attr('data-lang')).val($(this).find('.setting_value_holder').val());
                        }
                    });
                } else {
                    $('#setting_value').val($('#setting_' + settingId).val());
                }

                $('body, html').animate({scrollTop: $('#form-heading').offset().top + 'px'}, 1500);

            })

        });


        /* On form reset */


        $('#setting_options').on('reset', function (e) {

            $('#form-heading').find('.mode').text('Create');
            $('#setting_id').val('')


        });

        $('.settings-tabs a').on('click', function (e) {
            e.preventDefault();

            var $targetTab = $($(this).attr('href'));

            $('.setting-tab.active-tab').removeClass('active-tab');
            $targetTab.addClass('active-tab');

        })
    })


})(jQuery);
