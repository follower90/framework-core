app.registerModule('Router', {
	run: function() {
		var _ = this;

		this.update();
		window.onhashchange = function() {
			_.update();
		};
	},

	update: function () {
		for (var url in app._registry.routes) {

			var args = this._matches(url, window.location.hash);

			if (args) {
				var route = app._registry.routes[url];

				var params = route.params || {},
					component = app._registry.components[route.page];

				params = app.utils.extend(args, params);

				if (component) {
					component.activate(params);
				} else {
					app.error('Component: ' + route.page + ' not found');
				}
			}
		}
	},

	_matches: function (patt, url) {
		if (url == '') url = '#/';

		var parts = patt.split('/'),
			urlParts = url.split('/'),
			args = [];

		if (parts.length != urlParts.length) {
			return false;
		}

		for (var i = 0; i < parts.length; i++) {
			if (parts[i] != urlParts[i]) {
				if (parts[i][0] != ':') {
					return false;
				}

				var param = parts[i].slice(1);
				args[param] = urlParts[i];
			}
		}

		return args;
	}
});

