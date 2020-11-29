export let standings = {

	selector : '.do-toggle-standings',

	bind : function() {

		console.log('binding standings ui..');

		this.toggleStandings();

	},

	toggleStandings : function(selector = this.selector) {

		if( document.querySelector(selector) === null ) return;

		let ui = document.querySelector(selector);

		ui.addEventListener('change', (event) => {

			//event.target.value
			
			let url = ui.options[ ui.selectedIndex ].dataset.url;
			window.location.href = url;

		});


	},

}