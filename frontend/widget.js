(function (vf) {
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
			var container = vf.dom.find1(this.container);
			if (container) {
				var template = vf.utils.loadTemplate(this.template),
					rendered = vf.utils.render(template, this.templateOptions);

				container.innerHTML = rendered;
			}

			this._renderInlineWidgets();
		},

		_renderInlineWidgets: function() {
			for (var alias in this.inlineWidgets) {
				var widget = this.inlineWidgets[alias];

				if (widget) {
					widget.load();
					widget.render();
				}
			}
		}
	});
})(vf);
