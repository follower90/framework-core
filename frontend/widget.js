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

		if (this.dom) {
			this.load();
			this.renderInlineWidgets();
		} else {
			this.loadTemplate();
		}
	},

	loadTemplate: function () {
		vf.utils.loadTemplate(this.template, function(template) {
			this.dom = template;
			this.load(this.params);
			this.renderInlineWidgets();
		}.bind(this));
	},

	load: function() {
		this.includeInlineWidgets();
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
		container.innerHTML = vf.utils.render(this.dom, this.templateOptions);
	},

	afterRender: function() {
	},

	includeInlineWidgets: function() {
		this.inlineWidgets = {};

		for (var alias in this.widgets) {
			var inlineWidget = this.widgets[alias];

			if (inlineWidget.widget) {
				this.inlineWidgets[alias] = vf.widgets[inlineWidget.widget];
			} else {
				this.inlineWidgets[alias] = vf.utils.extend(vf.utils.extend({}, vf.modules.Widget), inlineWidget);
			}
		}

	},

	renderInlineWidgets: function() {
		for (var w in this.inlineWidgets) {
			var widget = this.inlineWidgets[w];

			if (widget) {
				widget.activate();
			}
		}
	}
});
