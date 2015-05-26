(function () {

	/*
	Core global framework object
	Everything is registered there
	 */

	vf = {

		/*
		Main registry object
		contains: controllers, components, models, routes, templates and environment variables
		 */
		_registry: {
			modules: {},
			components: {},
			controllers: {},
			models: {},
			routes: {},
			templates: {},
			options: {},
			environment: {}
		},

		/*
		Site environment objects
		and methods
		 */
		site: {
			user: false,
			gotoPage: function(page) {
				window.location.hash = page;
			}
		},

		module: function (alias) {
			return this._registry.modules[alias];
		},

		registerModule: function(alias, object) {
			this._registry.modules[alias] = object;
		},

		registerRoutes: function(object) {
			this._registry.routes = vf.utils.extend(vf.utils.extend({}, this._registry.routes), object);
		},

		registerOption: function(alias, value) {
			this._registry.options[alias] = value;
		},

		registerComponent: function(alias, object, parent) {
			if (!parent) {
				parent = vf.module('Component');
			}

			this._registry.components[alias] = vf.utils.extend(vf.utils.extend({}, parent), object);
		},

		error: function(text) {
			//todo implement backtrace
			console.error('vfDebugger: ' + text);
		},

		require: function(forInjection, callback, loaded) {
			//todo apply somewhere or remove
			var _ = this;

			if (!loaded) {
				loaded = [];
			}

			for (var i in forInjection) {
				if (!!loaded[i] && loaded[i].alias == forInjection[i]) {
					continue;
				}

				if (!!eval(forInjection[i])) {
					loaded.push(eval(forInjection[i]));
				} else {
					vf.Event.register(forInjection[i] + '_Loaded', function (component) {
						if (!loaded) {
							loaded = [];
						}

						loaded.push(component);
						_.require(forInjection, callback, loaded);
					});
				}
			}

			if (loaded.length == forInjection.length) {
				callback.apply(this, loaded);
			}
		},

		utils: {
			extend: function (obj1, obj2) {
				for (var p in obj2) {
					try {
						if (obj2[p].constructor == Object) {
							obj1[p] = vf.utils.extend(obj1[p], obj2[p]);
						} else {
							obj1[p] = obj2[p];
						}
					} catch (e) {
						obj1[p] = obj2[p];
					}
				}

				return obj1;
			},

			objectToArray: function(object) {
				return Object.keys(object).map(function (key) {return object[key]});
			},

			loadTemplate: function(template, callback) {
				return vf.module('Api').get(vf._registry.options.templates + template + '.tpl', 'text/html', callback);
			},

			render: function (template, vars) {
				for (var i in vars) {
					template = template.replace('{{' + i + '}}', vars[i]);
				}

				return template;
			}
		},

		dom: {
			find: function (query) {
				return window.document.querySelectorAll(query);
			},

			find1: function (query) {
				return window.document.querySelector(query);
			}
		}
	};

	window.vf = vf;
})();
