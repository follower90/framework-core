app.registerModule('Api', {
	get: function (url, type, callback) {
		this._api().get(url, type, callback);
	},
	post: function (url, type, params, callback) {
		this._api().post(url, type, params, callback);
	},

	_api: function () {
		var Api = function () {
			return {
				_contentType: '',
				_callback: function () {
				},

				get: function (url, contentType, callback) {
					this._request(url, 'GET');
					this._callback = callback;
					this._contentType = contentType;
					return this;
				},

				post: function (url, contentType, params, callback) {
					this._request(url, 'POST', callback, params);
					this._callback = callback;
					this._contentType = contentType;
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
							var dataString = '';
							for (var key in params) {
								dataString += key + '=' + params[key] + '&';
							}

							xmlHttp.open('POST', url, true);
							xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
							xmlHttp.send(dataString.slice(0,-1));
							break;
					}

					xmlHttp.onreadystatechange = function () {
						if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
							if (api._callback) {
								switch (api._contentType) {
									case 'text/html':
										var parser = new DOMParser(),
											dom = parser.parseFromString(xmlHttp.responseText, "text/html"),
											result = dom.body.innerHTML;
										break;
									case 'json':
											result = JSON.parse(xmlHttp.responseText);
										break;
									default:
										result = xmlHttp.responseText;
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
