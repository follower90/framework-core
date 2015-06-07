vf.registerModule('Component', {

	container: '',
	template: '',
	dom: false,
	templateOptions: {},

	beforeActivate: function (params) {
	},

	activate: function (params) {
		this.params = params;
		this.beforeActivate(this.params);

		if (this.dom) {
			this.load();
			this.renderComponents();
		} else {
			this.loadTemplate();
		}
	},

	loadTemplate: function () {
		vf.utils.loadTemplate(this.template, function (template) {
			this.dom = template;
			this.load(this.params);
			this.renderComponents();
		}.bind(this));
	},

	load: function () {
		this.loadComponents();
		this.beforeRender();
		this.render();
		this.afterRender();
	},

	setTemplateOptions: function (obj) {
		this.templateOptions = obj;
		return this;
	},

	beforeRender: function (params) {
	},

	render: function () {
		var container = vf.dom.find1(this.container);

		if (container) {
			$(this.container).fadeOut(0);
			container.innerHTML = vf.utils.render(this.dom, this.templateOptions);
			$(this.container).fadeIn(500);
		} else {
			throw 'Container error';
		}

		this.registerDOMHandlers();
	},

	afterRender: function () {
	},

	loadComponents: function () {
		this.inlineComponents = {};

		for (var alias in this.components) {
			var component = this.components[alias];

			if (component.use) {
				this.inlineComponents[alias] = vf.utils.extend(
					vf.utils.extend({}, this.getComponent(component.use)), component);

				for (var opt in component) {
					this.inlineComponents[alias][opt] = component[opt];
				}
			} else {
				this.inlineComponents[alias] = this.getComponent(component);
			}
		}
	},

	getComponent: function (alias) {
		return vf._registry.components[alias];
	},

	getInlineComponent: function (alias) {
		return this.inlineComponents[alias];
	},

	renderComponents: function () {
		for (var c in this.inlineComponents) {
			var component = this.inlineComponents[c];

			if (component) {
				component.activate(this.params);
			}
		}
	},

	registerDOMHandlers: function () {
		if (!!this.domHandlers) {
			for (var i in this.domHandlers) {
				var handler = this.domHandlers[i],
					callback = handler.callback,
					target = vf.dom.find1(this.container + ' ' + handler.element),
					_ = this;

				if (!!target) {
					target.addEventListener(handler.event, function () {
						_[callback].call(_, target, handler);
					});
				}
			}
		}
	},

	find1: function (query) {
		return vf.dom.find1(this.container + ' ' + query);
	},

	find: function (query) {
		return vf.dom.find(this.container + ' ' + query);
	}
});
