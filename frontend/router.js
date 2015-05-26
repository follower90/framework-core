vf.registerModule('Router', {
	run: function() {
		var _ = this;

		this.update();
		window.onhashchange = function() {
			_.update();
		};
	},

	update: function () {
		for (var url in vf._registry.routes) {

			var args = this._matches(url, window.location.hash);

			if (args) {
				var route = vf._registry.routes[url];

				var params = route.params || {},
					widget = vf._registry.components[route.page];

				params = vf.utils.extend(args, params);

				if (widget) {
					widget.activate(params);
				} else {
					vf.error('Widget: ' + route.page + ' not found');
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

