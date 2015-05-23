(function () {
	var vf = {

		widgets: {},
		_options: {},

		user: false,

		module: function (name, module) {
			this[name] = module;

			module.extend = function (alias, userComponent) {
				var component = vf.utils.extend(vf.utils.extend({}, module), userComponent);
				component.alias = alias;
				vf.Event.trigger(alias + '_Loaded', component);
				return component;
			};
		},

		registerOption: function(alias, value) {
			this._options[alias] = value;
		},

		widget: function (name, widget) {
			this.widgets[name] = vf.Widget.extend(widget);
		},

		error: function(text) {
			console.error('vfDebugger: ' + text);
		},

		require: function(forInjection, callback, loaded) {
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
				return vf.Api.get(vf._options.templates + template + '.tpl', 'text/html', callback);
			},

			render: function (template, vars) {
				for (var i in vars) {
					template = template.replace('{{' + i + '}}', vars[i]);
				}

				return template;
			}
		},

		site: {
			gotoPage: function(page) {
				window.location.hash = page;
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
