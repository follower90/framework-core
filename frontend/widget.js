vf.module('Widget', {

	container: '',
	template: '',
	dom: false,
	templateOptions: {},

	beforeActivate: function(params) {
	},

	activate: function(params) {
		this.params = params;
		this.beforeActivate(this.params);

		if (this.autoRender != false || !params) {
			if (this.dom) {
				this.load();
				this.renderWidgets();
			} else {
				this.loadTemplate();
			}
		}
	},

	loadTemplate: function () {
		vf.utils.loadTemplate(this.template, function(template) {
			this.dom = template;
			this.load(this.params);
			this.renderWidgets();
		}.bind(this));
	},

	load: function() {
		this.includeWidgets();
		this.beforeRender();
		this.render();
		this.afterRender();
	},

	setTemplateOptions: function(obj) {
		this.templateOptions = obj;
		return this;
	},

	beforeRender: function(params) {
	},

	render: function() {
		var container = vf.dom.find1(this.container);

		if (container) {
			//$(this.container).fadeOut(0);
			container.innerHTML = vf.utils.render(this.dom, this.templateOptions);
		//	$(this.container).fadeIn(500);
		} else {
			throw 'Container error';
		}

		this.registerDOMHandlers();
	},

	afterRender: function() {
	},

	includeWidgets: function() {
		this.inlineWidgets = {};

		for (var alias in this.widgets) {
			var inlineWidget = this.widgets[alias];

			if (inlineWidget.widget) {
				this.inlineWidgets[alias] = inlineWidget.widget;

				for (var opt in inlineWidget) {
					this.inlineWidgets[alias][opt] = inlineWidget[opt];
				}
			} else {
				this.inlineWidgets[alias] = inlineWidget;
			}
		}

	},

	renderWidgets: function() {
		for (var w in this.inlineWidgets) {
			var widget = this.inlineWidgets[w];

			if (widget) {
				widget.activate(this.params);
			}
		}
	},

	registerDOMHandlers: function() {
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

	find1: function(query) {
		return vf.dom.find1(this.container + ' ' + query);
	},

	find: function(query) {
		return vf.dom.find(this.container + ' ' + query);
	}

});
