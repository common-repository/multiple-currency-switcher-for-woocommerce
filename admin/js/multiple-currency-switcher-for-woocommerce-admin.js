(function ($) {
	'use strict';

	$(document).ready(function () {

		var response;
		var requestURL = 'http://api.exchangeratesapi.io/v1/latest?access_key=a6f47d295bc5c02f74cbac997934bf73';
		var request = new XMLHttpRequest();
		request.open('GET', requestURL);
		request.responseType = 'json';
		request.send();
		request.onload = function () {
			response = request.response;
		}

		$('.multiple-currency-selected').select2({});

		// drop down change event
		$(document).on('change', '.multiple-currency-selected', function () {

			var currentThis,
				currentThisValue,
				defaultCurrency,
				woocommerceCurrencyPositionSelected,
				curentCurrencyRate,
				curentCurrencyExchangeRate,
				curentCurrencyNumberDecimals,
				defaultCurrencyChecked,
				enableAutoFixedPriceRate;

			currentThis = $(this);
			currentThisValue = currentThis.val();

			defaultCurrency = currentThis.parent().closest('tr').find('.default-currency');
			woocommerceCurrencyPositionSelected = currentThis.parent().closest('tr').find('.multiple-currency-switcher-position-selected');
			curentCurrencyRate = currentThis.parent().closest('tr').find('.current-currency-rate');
			curentCurrencyExchangeRate = currentThis.parent().closest('tr').find('.current-currency-exchange-rate');
			curentCurrencyNumberDecimals = currentThis.parent().closest('tr').find('.current-currency-number-decimals');


			// auto update rate is active
			enableAutoFixedPriceRate = multiple_currency_admin_data.enableAutoFixedPriceRate

			if (enableAutoFixedPriceRate !== '') {

				// curent rate value update 
				curentCurrencyRate.val(response['rates'][currentThisValue]);

				// get default checked val
				defaultCurrencyChecked = $('.default-currency:checked');

				// exchange rate value update
				var requestURL = 'https://api.exchangerate.host/convert?from=' + defaultCurrencyChecked.val() + '&to=' + currentThisValue + '';
				var request = new XMLHttpRequest();
				request.open('GET', requestURL);
				request.responseType = 'json';
				request.send();

				request.onload = function () {
					var responseExchangeRate = request.response;
					curentCurrencyExchangeRate.val(responseExchangeRate['result']);
				}

			}

			// attr name update
			defaultCurrency.val(currentThisValue);
			woocommerceCurrencyPositionSelected.attr('name', 'multiple_currency_switcher[_currency_position_set][' + currentThisValue + ']');
			curentCurrencyRate.attr('name', 'multiple_currency_switcher[_current_currency_rate][' + currentThisValue + ']');
			curentCurrencyExchangeRate.attr('name', 'multiple_currency_switcher[_current_currency_exchange_rate][' + currentThisValue + ']');
			curentCurrencyNumberDecimals.attr('name', 'multiple_currency_switcher[_current_currency_number_decimals][' + currentThisValue + ']');
		});



		$(document).on('click', '.multiple-currency-fixed-price-rate', function () {
			$('.multiple-currency-fixed-price-rate').prop('checked', false);
			var currentThis;
			currentThis = $(this);
			currentThis.prop('checked', true);
		});

		// default checkbox select change all rates 
		$(document).on('click', '.default-currency', function () {

			$('.default-currency').prop('checked', false);

			var currentThis,
				currentThisValue,
				curentCurrencyRate,
				curentCurrencyExchangeRate,
				enableAutoFixedPriceRate;

			currentThis = $(this);
			currentThis.prop('checked', true);
			curentCurrencyRate = currentThis.parent().closest('tr').find('.current-currency-rate');
			curentCurrencyExchangeRate = currentThis.parent().closest('tr').find('.current-currency-exchange-rate');

			// auto update rate is active
			enableAutoFixedPriceRate = multiple_currency_admin_data.enableAutoFixedPriceRate

			if (enableAutoFixedPriceRate !== '') {

				currentThisValue = currentThis.val();

				$('.default-currency').map(function () {

					if (currentThisValue !== this.value) {

						var curentCurrencyExchangeRateSet = $(this).parent().closest('tr').find('.current-currency-exchange-rate')
						curentCurrencyRate = $(this).parent().closest('tr').find('.current-currency-rate');

						// curent rate value update 
						curentCurrencyRate.val(response['rates'][this.value])

						// curent exchange rate value update 
						var requestURL = 'https://api.exchangerate.host/convert?from=' + currentThisValue + '&to=' + this.value + '';
						var request = new XMLHttpRequest();
						request.open('GET', requestURL);
						request.responseType = 'json';
						request.send();
						request.onload = function () {
							var responseExchangeRate = request.response;
							curentCurrencyExchangeRateSet.val(responseExchangeRate['result']);
						}
					}
				});
			}

		});

		//  add new table row with data country
		$(document).on('click', '#currency-new-row-add', function (event) {
			console.log(response);
			$('.multiple-currency-switcher-tbody').append(
				'<tr>' +
				'<td>' +
				'<label for="multiple-currency-switcher-label">Default Currency</label>' +
				'</td>' +
				'<td>' +
				'<fieldset>' +
				'<label class="multiple-currency-switcher">' +
				'<input type="checkbox" class="checkbox default-currency" name="multiple_currency_switcher[_default_currency][]" value="AED" >' +
				'<div class="multiple-currency-slider"></div>' +
				'</label>' +
				'</fieldset>' +
				'</td>' +
				'<td>' +
				'<fieldset>' +
				'<select class="form-select multiple-currency-selected" name="multiple_currency_switcher[_default_country_selected][]" aria-label="Default select example">' +
				'</select>' +
				'</fieldset>' +
				'</td>' +
				'<td>' +
				'<fieldset>' +
				'<select class="form-select multiple-currency-switcher-position-selected" name="multiple_currency_switcher[_currency_position_set][]" aria-label="Default select example">' +
				'</select>' +
				'</fieldset>' +
				'</td>' +
				'<td>' +
				'<fieldset>' +
				'<input type="text" name="multiple_currency_switcher[_current_currency_rate][AED]" class="form-control current-currency-rate" value="' + response["rates"]["AED"] + '" >' +
				'</fieldset>' +
				'</td>' +
				'<td>' +
				'<fieldset>' +
				'<input type="text" name="multiple_currency_switcher[_current_currency_exchange_rate][AED]" class="form-control current-currency-exchange-rate" value="' + response["rates"]["AED"] + '" >' +
				'</fieldset>' +
				'</td>' +
				'<td>' +
				'<fieldset>' +
				'<input type="text" name="multiple_currency_switcher[_current_currency_number_decimals][AED]" class="form-control current-currency-number-decimals" value="2">' +
				'</fieldset>' +
				'</td>' +
				'<td>' +
				'<fieldset class="delete_cry">' +
				'<button class="delete-country" >Delete</button>' +
				'</fieldset>' +
				'</td>' +
				'</tr>'
			);


			$.each(multiple_currency_admin_data.currencyCodeOptions, function (key, value) {
				$('.multiple-currency-selected').append(value);
			});

			$.each(multiple_currency_admin_data.currencyPositionOptions, function (key, value) {
				$('.multiple-currency-switcher-position-selected').append(value);
			});

			$('.multiple-currency-selected').select2({});
			event.preventDefault();
		});

		// delete table country row
		$(document).on('click', '.delete-country', function (event) {
			$(this).parent().closest('tr').remove();
			event.preventDefault();
		});

	});
})(jQuery);


