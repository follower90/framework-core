(function () {
	var vf = {

		widgets: {},
		_options: {},

		user: false,

		module: function (name, component) {
			this[name] = component;

			component.extend = function (userComponent) {
				return vf.utils.extend(vf.utils.extend({}, component), userComponent);
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