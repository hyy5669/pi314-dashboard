$(function()
{
  $('input#metric-submit1').on('click', function(e) {
	e.preventDefault();
	var table1 = $('select#table1').val();
	var dt1 = $('input#dt1').val();
	var dt2 = $('input#dt2').val();
	if ($.trim(table1) != '' && $.trim(dt1) != '' && $.trim(dt2) != '') {
		$.post('ajax/plot.php', {table1: table1, dt1: dt1, dt2: dt2}, function(data1) {
			$('div#metric-plots').html(data1);
		});
		$.post('ajax/getstats.php', {table1: table1, dt1: dt1, dt2: dt2}, function(data2) {
			$('div#metric-stats').html(data2);
		});
	}
  });
});