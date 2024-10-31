(function ($) {
	'use strict';

	$(document).on('click', '.multiple-currency-switcher-sidebar', function () {

		var currentThis,
			currentThisVal,
			admin_Url;

		currentThis = $(this);
		currentThisVal = currentThis.attr('data-id');
		admin_Url = multiple_currency_switcher_object.ajax_url;

		$.ajax({
			url: admin_Url,
			method: 'post',
			async: false,
			data: {
				currentCountry: currentThisVal,
				action: 'multiple_currency_switcher_data',
			},
			success: function (data) {

				if (data) {
					location.reload();
				}
			}
		})

	});


})(jQuery);
