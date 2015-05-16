vf.widget('selectBox', {

	//dom: '<select id="test"></select>',
	dom: '<p id="test"></p>',

	beforeRender: function () {

	},
	afterRender: function() {
		vf.dom.find1('#test').innerHTML = 'oloolo';
	}

});
