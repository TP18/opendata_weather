Opendata = {

	/**
	 * @return void
	 */
	init: function () {
		if (Opendata.Diagrams !== undefined) Opendata.Diagrams.init();
	},


	/**
	 * @param url
	 * @param data
	 * @param successCallback
	 */
	ajax: function (url, data, successCallback) {
		jQuery.ajax({
			type: 'POST',
			url: url,
			data: data,
			success: successCallback
		});
	}
};

jQuery(document).ready(function () {
	Opendata.init();
});
