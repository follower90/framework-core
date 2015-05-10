(function (vf) {
	vf.module('Api', {

		get: function (url) {
			var xmlHttp = new XMLHttpRequest();
			xmlHttp.open('GET', url, false);
			xmlHttp.send(null);

			return xmlHttp;
		},

		post: function (url, params) {
			var xmlHttp = new XMLHttpRequest();
			xmlHttp.open('POST', url, false);
			xmlHttp.send(new FormData(params));

			return xmlHttp;
		}
	});
})(vf);
