import Chart from 'chart.js';

export let charts = {

	init : function() {

		this.jumperChart();

	},

	jumperChart : function(selector) {

		if (typeof(jumperDatasets) === 'undefined') return;

		//https://www.chartjs.org/docs/latest/
		Chart.defaults.global.defaultFontFamily = 'Roboto';
		Chart.defaults.global.defaultFontSize = 14;

		let ctx = document.getElementById('competitionsChart');

		let lineChart = new Chart(ctx, {
		    type: 'line',
			data: {
				labels: jumperDatasets['labels'],
				datasets: [{
					label: 'Miejsce w konkursie',
					backgroundColor: '#213681',
					borderColor: '#213681',
					fill: false,
					data: jumperDatasets['competitions'],
				}, {
					label: 'Klasyfikacja generalna',
					backgroundColor: '#e72251',
					borderColor: '#e72251',
					fill: false,
					data: jumperDatasets['standings'],
				}]
			},
		    options: {
		    	//https://stackoverflow.com/a/34404201
			    elements: {
			        line: {
			            tension: 0
			        }
			    },
			    legend : {
			    	display: true,
			    	padding: 100,
			    },
		        scales: {
		            yAxes: [{
		                ticks: {
		                	beginAtZero : false,
		                	min: -1,
		                	padding: 25,
		                	stepSize: 1,
		                    reverse: true,
		                    suggestedMin: 1,
		                    suggestedMax: 50,

		                    //https://github.com/chartjs/Chart.js/issues/4202#issuecomment-380840237
							callback: function(value, index, values) {
								if (value > 0) {
									return values[index]
								}
							}

		                }
		            }],
		            xAxes: [{
		            	ticks: {
		            		display: false,
		            	}
		            }]
		        },
		        layout: {
		        	padding: {
		        		top: 25,
		        	}
		        }
		    }
		});

	}

}