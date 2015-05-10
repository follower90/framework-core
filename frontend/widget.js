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
				container.innerHTML = vf.utils.render(vf.templates[this.template], this.templateOptions);
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
