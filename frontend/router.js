(function (vf) {
	vf.module('Router', {

		routesMap: {},

		routes: function (map) {
			this.routesMap = vf.utils.extend(this.routesMap, map);
		},

		run: function () {
			for (var url in this.routesMap) {

				var args = this._matches(url, window.location.hash);

				if (args) {
					var route = this.routesMap[url];

					var params = route.params || {},
						widget = vf.widgets[route.page];

					params = vf.utils.extend(args, params);

					if (widget) {
						widget.load(params);
						widget.render();
					}
				}
			}
		},

		_matches: function (patt, url) {
			if (url == '#/') {
				url = '';
			}

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

})(vf);

window.onload = function () {
	vf.modules.Router.run();
};
