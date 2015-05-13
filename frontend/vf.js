(function () {
	var vf = {

		widgets: {},
		modules: {},
		templates: {},

		module: function (name, component) {
			this.modules[name] = component;
		},

		widget: function (name, widget) {

			this.widgets[name] = vf.utils.extend(vf.utils.extend({}, vf.modules.Widget), widget);
			this.widgets[name].inlineWidgets = {};

			var current = this.widgets[name];

			for (var alias in current.widgets) {
				current.inlineWidgets[alias] = vf.utils.extend(vf.utils.extend({}, current), current.widgets[alias]);
			}
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

			loadTemplate: function(template) {
				var html = vf.modules.Api.get('public/test/js/templates/' + template + '.tpl'),
					stringContainingXMLSource = html.responseText;

				var parser = new DOMParser();
				dom = parser.parseFromString(stringContainingXMLSource, "application/xml");
				console.log(dom.documentElement.innerHTML);
				return dom.documentElement.innerHTML;

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
