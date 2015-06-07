(function () {

	/**
	 * Core global framework object
	 * Everything is registered there
	 */

	var app = {

		/**
		 * Main registry object
		 * contains: controllers, components, models, routes, templates and environment variables
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

		/**
		 * Site environment objects and methods
		 */
		site: {
			user: false,
			gotoPage: function(page) {
				window.location.hash = page;
			}
		},

		/**
		 * returns registered module by alias
		 * @param alias
		 * @returns {*}
		 */
		module: function (alias) {
			return this._registry.modules[alias];
		},

		/**
		 * Register module in system
		 * @param alias
		 * @param object
		 */
		registerModule: function(alias, object) {
			this._registry.modules[alias] = object;
		},

		/**
		 * Registers routes
		 * @param object
		 */
		registerRoutes: function(object) {
			this._registry.routes = app.utils.extend(app.utils.extend({}, this._registry.routes), object);
		},

		/**
		 * Register option variables
		 * @param alias
		 * @param value
		 */
		registerOption: function(alias, value) {
			this._registry.options[alias] = value;
		},

		/**
		 * Registers user component
		 * @param alias
		 * @param object
		 * @param parent
		 */
		registerComponent: function(alias, object, parent) {
			if (!parent) {
				parent = app.module('Component');
			}

			this._registry.components[alias] = app.utils.extend(app.utils.extend({}, parent), object);
		},

		/**
		 * Console.error wrapper
		 * @todo implement backtrace, etc
		 * @param text
		 */
		error: function(text) {
			console.error('appDebugger: ' + text);
		},

		/**
		 * Utility functions
		 */
		utils: {
			/**
			 * Object extend function
			 * @param obj1 parent object
			 * @param obj2 child object
			 * @returns {*}
			 */
			extend: function (obj1, obj2) {
				for (var p in obj2) {
					try {
						if (obj2[p].constructor == Object) {
							obj1[p] = app.utils.extend(obj1[p], obj2[p]);
						} else {
							obj1[p] = obj2[p];
						}
					} catch (e) {
						obj1[p] = obj2[p];
					}
				}

				return obj1;
			},

			/**
			 * Converts object to array
			 * @param object
			 * @returns {Array}
			 */
			objectToArray: function(object) {
				return Object.keys(object).map(function (key) {return object[key]});
			},

			/**
			 * API request for template loading
			 * Runs callback function after load
			 * @param template
			 * @param callback
			 * @returns {*}
			 */
			loadTemplate: function(template, callback) {
				return app.module('Api').get(app._registry.options.templates + template + '.tpl', 'text/html', callback);
			},

			/**
			 * Replaces template options in template
			 * and returns rendered
			 * @param template
			 * @param vars
			 * @returns {*}
			 */
			render: function (template, vars) {
				for (var i in vars) {
					template = template.replace('{{' + i + '}}', vars[i]);
				}

				return template;
			}
		},

		dom: {
			/**
			 * Return DOM objects matched with query
			 * @param query
			 * @returns {NodeList}
			 */
			find: function (query) {
				return window.document.querySelectorAll(query);
			},

			/**
			 * Returns single DOM object matched with query
			 * @param query
			 * @returns {HTMLElement}
			 */
			find1: function (query) {
				return window.document.querySelector(query);
			}
		}
	};

	window.app = app;
})();
