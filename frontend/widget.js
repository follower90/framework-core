vf.module('Widget', {

	container: '',
	template: '',
	templateOptions: {},

	setTemplateOptions: function(obj) {
		this.templateOptions = obj;
	},

	load: function() {
	},

	render: function () {
		var container = vf.dom.find1(this.container),
			_w = this;

		if (container) {
			vf.utils.loadTemplate(this.template, function(template) {
				var rendered = vf.utils.render(template.firstChild.innerHTML, _w.templateOptions);
				container.innerHTML = rendered;
				_w.renderInlineWidgets();
			});
		}
	},

	renderInlineWidgets: function() {
		for (var alias in this.inlineWidgets) {
			var widget = this.inlineWidgets[alias];

			if (widget) {
				widget.load();
				widget.render();
			}
		}
	}
});
