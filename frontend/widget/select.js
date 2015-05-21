vf.widget('Select_Box', {

	dom: '<select></select>',

	beforeRender: function() {
		var options = '';
		if (!!this.templateOptions) {
			for (var i in this.templateOptions.data) {
				var id = this.templateOptions.data[i].id,
					name = this.templateOptions.data[i].name;

				options += '<option value="' + id + '">' + name + '</option>';
			}
			this.setTemplateOptions({options: options});
		}
	}

});
