app.registerModule('Event', {

	events: [],

	register: function (event, callback) {
		this.events.push({
			alias: event,
			callback: callback
		});
	},

	trigger: function(event, args) {
		for (var i in this.events) {
			if (event == this.events[i].alias) {
				this.events[i].callback(args);
				return;
			}
		}
	}
});
