jQuery(document).ready(function($) 
{
 function WinMove12() {

  var element = "#sortable";
  var handle = ".block";
  var connect = "#sortable";

    (function() {
      // get saved positions
      var positions = localStorage.getItem('all_orders')
      positions = positions ? JSON.parse(positions) : []
      // sort the list
      for (var i in positions) {
        var element = positions[i]
        $('[data-par_id="' + element.par_id + '"]').append(
          $('[data-col_id="' + element.col_id + '"]').detach()
        )
      }
    }) ()

  $(element).sortable({
      update: function(e, ui) {
        var parent = ui.item.closest('[data-par_id]');
        var positions = []
        $('[data-col_id]').each(function() {
          positions.push({
            col_id : $(this).data('col_id'),
            par_id : $(this).closest('[data-par_id]').data('par_id')
          })
        })
        localStorage.setItem('all_orders', JSON.stringify(positions))
      },
    handle: handle,
    connectWith: connect,
    tolerance: 'pointer',
    forcePlaceholderSize: true,
    opacity: 0.8
  }).disableSelection();
}

function WinMove2() {

  var element = "#sortable1";
  var handle = ".block";
  var connect = "#sortable1";

    (function() {
      // get saved positions
      var positions = localStorage.getItem('all_orders')
      positions = positions ? JSON.parse(positions) : []
      // sort the list
      for (var i in positions) {
        var element = positions[i]
        $('[data-par_id="' + element.par_id + '"]').append(
          $('[data-col_id="' + element.col_id + '"]').detach()
        )
      }
    }) ()

  $(element).sortable({
      update: function(e, ui) {
        var parent = ui.item.closest('[data-par_id]');
        var positions = []
        $('[data-col_id]').each(function() {
          positions.push({
            col_id : $(this).data('col_id'),
            par_id : $(this).closest('[data-par_id]').data('par_id')
          })
        })
        localStorage.setItem('all_orders', JSON.stringify(positions))
      },
    handle: handle,
    connectWith: connect,
    tolerance: 'pointer',
    forcePlaceholderSize: true,
    opacity: 0.8
  }).disableSelection();
}


  WinMove12();
  WinMove2();

		
	/* ---  Payment Details Chart  --- */
		var amount_array = [];
	    var method_array = [];
	    var colorList = [];
	    var colorlist_item = Array(   '#a8e6cf','#dcedc1','#ffd3b6','#ffaaa5','#ff8b94');
	
		$('.payment-gateway .data').each(function() 
	    {
	    	// method list
	    	var method = $(this).attr('data-method');
	    	method_array.push(method);

	    	//  amount list
	    	var amount = $(this).attr('data-amount');
	    	amount_array.push(amount);

	    	var item = colorlist_item[Math.floor(Math.random()*colorlist_item.length)];   
	        colorList.push(item);
	    });
		var config = {
	                type: 'pie',
	                data: {
	                  datasets: [{
	                    data: amount_array,
	                    backgroundColor: colorlist_item,
	                    label: 'Dataset 1'
	                  }],
	                  labels: method_array
	                },  
	            };
        var ctx = document.getElementById('payment_chart');
        var year_chart = new Chart(ctx, config);

    /* ---  Payment Details Chart  --- */


        /* ---  Existing - New User Chart  --- */

	        var day_arr = [];
	        var day_amount_arr = [];

	        $('.this-month .data').each(function() 
	        {
	          var day = $(this).attr('data-day');
	          var day_amount = $(this).attr('data-amount');
	          day_arr.push(day);
	          day_amount_arr.push(day_amount);
	        });

	        var barChartData = {
	                labels: day_arr,
	                datasets: [{
	                  label: 'Sales',
	                  backgroundColor: '#faaaa5',
	                  borderColor: '#fff',
	                  borderWidth: 1,
	                  data: day_amount_arr,
	                }]

	            }; 

	        var ctx = document.getElementById('sale_this_month_chart');
	        var myBar = new Chart(ctx, {
	                        type: 'horizontalBar',
	                        data: barChartData,
	                        options: {
	                         /* responsive: true,*/
	                          legend: {
	                            position: 'top',
	                          },
	                          scales: {
	                              yAxes: [{id: 'y-axis-1', position: 'left', ticks: {min: 0}}]
	                            },
	                          title: {
	                            display: true,
	                            text: ''
	                          }
	                        }
	                      });

        /* ---  Existing - New User Chart  --- */


        /* ---  Existing - New User Chart  --- */
			var old_user_per = $('.user-details .user-data').attr('data-old-user-per');
			var new_user_per = $('.user-details .user-data').attr('data-new-user-per');
	 
	      	var user_arr = [];
	      	var user_type_arr = [];
      
		    user_arr.push(old_user_per);
		    user_type_arr.push('Existing Customer');

		    user_arr.push(new_user_per);
		    user_type_arr.push('New Customer');

		    var config = {
			            type: 'pie',
			            data: {
			            datasets: [{
			            data: user_arr,
			            backgroundColor: colorlist_item,
			            label: 'Dataset 1'
		            }],
		            labels: user_type_arr
		        },  
		    };

		    var ctx = document.getElementById('user_chart');
		    var year_chart = new Chart(ctx, config);

   		/* ---  Existing - New User Chart  --- */



   		/* ---  6 Month Sales Chart  --- */

   			var month_arr = [];
   			var sales_arr = [];

	   		$('.six-month .data').each(function() 
	        {
	          var month = $(this).attr('data-month');
	          month_arr.push(month);

	          var sales = $(this).attr('data-sales');
	          sales_arr.push(sales);

	        });

	   		var barChartData = {
                labels: month_arr,
                datasets: [{
                  label: 'Sales',
                  backgroundColor: '#ffd3b6',
                  borderColor: '#fff',
                  borderWidth: 1,
                  data: sales_arr,
                }]

            }; 

	   		var ctx = document.getElementById('six_month_chart');
        	var myBar = new Chart(ctx, {
                        type: 'bar',
                        data: barChartData,
                        options: {
                         /* responsive: true,*/
                          legend: {
                            position: 'top',
                          },
                          scales: {
                              yAxes: [{id: 'y-axis-1', position: 'left', ticks: {min: 0}}]
                            },
                          title: {
                            display: true,
                            text: ''
                          }
                        }
                      });
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			// test
			var day23 = [];
			 $('.user-data1').each(function() {
	          		var day1 = $(this).attr('monthly_order_total');
	          		day23.push(day1);
	        	});
			var options = {
				        scales: {
				            xAxes: [{
				                stacked: true
				            }],
				            yAxes: [{
				                stacked: true
				            }]
				        }
				    };
			var method_array23 = ['Last Month','This Month'];
			var ctx = document.getElementById('six_month_chart2');
			var stackedBar = new Chart(ctx, {
			    type: 'bar',
			    data: {
					    labels: method_array23,
		                datasets: [{
		                  label: 'Sales',
		                  backgroundColor: '#a8e6cf',
		                  borderColor: '#ffd3b6',
		                  borderWidth: 1,
		                  data: day23,
		                   }]
					},
			    options: {
                         /* responsive: true,*/
                          legend: {
                            position: 'top',
                          },
                          scales: {
                              yAxes: [{id: 'y-axis-1', position: 'left', ticks: {min: 0}}]
                            },
                          title: {
                            display: true,
                            text: ''
                          }
                        },
			});


// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		
		var weekdata = [];
		var	lastweekdata = [];
			 $('.wekly-data').each(function() {

	          		var week1 = $(this).attr('monthly_order_total');
	          		weekdata.push(week1);

					var lastweek = $(this).attr('last_week_order_total');
	          		lastweekdata.push(lastweek);

	        	});

		var lineChartData = {
			labels: ['S','M','T','W','T','F','S'],
			datasets: [{
				label: 'This Week',
				borderColor: '#f66183',
				fill: false,
				data: weekdata
			},{
				label: 'Last Week',
				borderColor: '#36a2eb',
				fill: false,
				data: lastweekdata
			}]
		};

			var ctx = document.getElementById('week_comp');
			var stackedLine = new Chart(ctx, {
								    type: 'line',
								    data: lineChartData,
								    options: {
											yAxes: [{
												type: 'linear', // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
												display: true,
												position: 'left',
												id: 'y-axis-1',
											}, {
												type: 'linear', // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
												display: true,
												position: 'right',
												id: 'y-axis-2',

											}],
									}
								});

// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			
		var catdata = [];
		// var	lastweekdata = [];
			 $('.cat-data').each(function() {

	          		var week1 = $(this).attr('category');
	          		catdata.push(week1);

	        	});
		var catdata1 = []; 
		var	category_name = [];
		 $('.cat-data1').each(function() {
					var lastweek1 = $(this).attr('category1');
					var categoryname = $(this).attr('category_name');

	          		catdata1.push(lastweek1);
	          		category_name.push(categoryname);
	          		
	        	});


			var colorlist_item1 = Array('#a8e6cf','#dcedc1','#ffd3b6','#ffaaa5','#ff8b94');
			var data34 = {
			    datasets: [{
			        label:'Orders',
			    	backgroundColor:colorlist_item1,
			    	// weight:1,
			    	cutoutPercentage: 5,
			        data: catdata1 
			    }],

			    // These labels appear in the legend and in the tooltips when hovering different arcs
			    labels: category_name
			};
			var options = { cutoutPercentage: 70 };

			var ctx = document.getElementById('category');
			var myDoughnutChart = new Chart(ctx, {
    									type: 'doughnut',
									    data: data34,
									    options: options
									});

//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 

						var country = []; 
						var country2 = [];
						var tt=[];
			          	// tt['Country']='Total';
				 		$('.map-data').each(function() {
							var lastweek1 = $(this).attr('country');
							var lastweek2 = $(this).attr('country2');

			          		tt[lastweek1]=parseInt(lastweek2);
			        	});

  						google.charts.load('current', {
					        'packages':['geochart'],
					        'mapsApiKey': 'AIzaSyD-9tSrke72PouQMnMX-a7eZSW0jkFMBWY'
					    });
						google.charts.setOnLoadCallback(drawRegionsMap);

					    function drawRegionsMap() {
					    	dt = new google.visualization.DataTable();
					    	dt.addColumn('string', 'Country');
        					dt.addColumn('number', 'Order');
        					for(var k in tt){
					          	dt.addRow([k,tt[k]]);
					        }
					        var options = {
					        	'colors': ['lightgreen', 'lightblue'],
					        };

					        var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));

					         function resize () {
								    chart.draw(dt, options);
							}
							if (window.addEventListener) {
							    window.addEventListener('resize', resize);
							}
							else {
							    window.attachEvent('onresize', resize);
							}
					        chart.draw(dt, options);
					      }
});