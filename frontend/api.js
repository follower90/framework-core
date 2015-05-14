vf.module('Api', {

	get: function (url, type) {
		this._request(url, 'GET');
		this._type = type;
		return this;
	},

	post: function (url, type, params) {
		this._request(url, 'POST', params);
		this._type = type;
		return this;
	},

	response: function(callback) {
		this._callback = callback;
	},

	_request: function(url, type, callback, params) {
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

		xmlHttp.onreadystatechange = function() {
			if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
				if (api._callback) {
						switch(api._type) {
							case 'text/html':
								var parser = new DOMParser();
								var result  = parser.parseFromString(xmlHttp.responseText, "text/html");
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
});
