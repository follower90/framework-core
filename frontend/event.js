vf.module('Event', {
	events: {},
	register: function (event, callback) {
		this.events.push({
			alias: event,
			callback: callback
		});
	},

	trigger: function(event) {
		for (var i in this.events) {
			if (event == events[i].alias) {
				events[i].callback();
				return;
			}
		}
	}
});
