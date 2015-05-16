vf.module('Api', {
	get: function (url, type, callback) {
		this._api().get(url, type, callback);
	},
	post:  function (url, type, params, callback) {
		this._api().post(url, type, params, callback);
	},

	_api: function() {
		var Api = function () {

			return {

				get: function (url, type, callback) {
					this._request(url, 'GET');
					this._callback = callback;
					this._type = type;
					return this;
				},

				post: function (url, type, params, callback) {
					this._request(url, 'POST', params);
					this._callback = callback;
					this._type = type;
					return this;
				},

				_request: function (url, type, callback, params) {
					var xmlHttp = new XMLHttpRequest(),
						api = this;

					switch (type) {
						case 'GET':
							xmlHttp.open('GET', url, true);
							xmlHttp.send(null);
							break;

						case 'POST':
							xmlHttp.open('POST', url, true);
							xmlHttp.send(new FormData(params));
							break;
					}

					xmlHttp.onreadystatechange = function () {
						if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
							if (api._callback) {
								switch (api._type) {
									case 'text/html':
										var parser = new DOMParser(),
											dom = parser.parseFromString(xmlHttp.responseText, "text/html"),
											result = dom.body.innerHTML;
										break;
									default:
										result = xmlHttp;
										break;
								}

								api._result = api._callback(result);
							}
						}
					};
				}
			}
		};

		return new Api();
	}
});
