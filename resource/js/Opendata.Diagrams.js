Opendata.Diagrams = {


	/**
	 *
	 */
	date: null,


	/**
	 *
	 */
	temp: null,


	/**
	 *
	 */
	rain: null,


	/**
	 *
	 */
	cityName: null,


	/**
	 *
	 * @param event
	 */
	init: function (event) {
		Opendata.Diagrams.initPieChart();
	},

	/**
	 * @var Object
	 */
	chartConfig: {
		chart: {
			plotBackgroundColor: null,
			plotBorderWidth: 0,
			plotShadow: false,
			backgroundColor: 'transparent'
		},
		colors: ['#7cb5ec', '#434348', '#90ed7d', '#e4d354'],
		credits: {
			enabled: false
		},
		title: {
			text: '',
			align: 'center',
			verticalAlign: 'middle',
			y: 50
		}
	},


	/**
	 *
	 */
	initPieChart: function () {

		$('#container').highcharts({
			credits: {
				enabled: false
			},
			chart: {
				zoomType: 'xy'
			},
			title: {
				text: '15-day weather forecast for '  + Opendata.Diagrams.cityName + ' (Temperature and Rainfall)'
			},
			subtitle: {
				text: 'Opendata'
			},
			xAxis: [
				{
					categories: Opendata.Diagrams.date
				}
			],
			yAxis: [
				{ // Primary yAxis
					labels: {
						format: '{value}°C',
						style: {
							color: Highcharts.getOptions().colors[1]
						}
					},
					title: {
						text: 'Temperature',
						style: {
							color: Highcharts.getOptions().colors[1]
						}
					}
				},
				{ // Secondary yAxis
					title: {
						text: 'Rainfall',
						style: {
							color: Highcharts.getOptions().colors[0]
						}
					},
					labels: {
						format: '{value} mm',
						style: {
							color: Highcharts.getOptions().colors[0]
						}
					},
					opposite: true
				}
			],
			tooltip: {
				shared: true
			},
			legend: {
				layout: 'vertical',
				align: 'left',
				x: 120,
				verticalAlign: 'top',
				y: 100,
				floating: true,
				backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
			},
			series: [
				{
					name: 'Rainfall',
					type: 'column',
					yAxis: 1,
					data: Opendata.Diagrams.rain,
					tooltip: {
						valueSuffix: ' mm'
					}

				},
				{
					name: 'Temperature',
					type: 'spline',
					data: Opendata.Diagrams.temp,
					tooltip: {
						valueSuffix: '°C'
					}
				}
			]
		});
	}

};
