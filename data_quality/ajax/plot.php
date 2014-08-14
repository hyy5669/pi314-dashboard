<?php
function run_query($qry_m, $link) {
    $qry_explode = array_filter(explode(';', trim($qry_m)));
    foreach ($qry_explode as $k => $qry) {
        $result = mysql_query($qry, $link);
        if (!$result) {
            throw new Exception("Could not run query $qry: " . mysql_error($link));
        }
        $result_array = array();
        try {
            while ($r = mysql_fetch_assoc($result)) {
                $result_array[] = $r;
            }
        } catch (Exception $e) {
            //echo "COULD NOT GET A VALUE OUT.";
        }
    }

    return $result_array;
}


function h($string) {
    return htmlspecialchars($string, ENT_QUOTES, "utf-8");
}


function prepare_graph($data_array) {
    $graph_array = array();
    $first_key = '';
    foreach ($data_array as $row_num => $row) {
        foreach ($row as $keys => $values) {
            if (isset($first_key)) {
                $first_key = $keys;
            }
            if (is_numeric($values)) {
                $graph_array[$keys][] = h($values);
            } else {
                $graph_array[$keys][] = "'" . h($values) . "'";
            }
        }
    }
    return array('graph_array' => $graph_array, 'first_key' => $first_key);
}

function pivot($data_array) {
    $pivot_array = array();
    $graph_array = array();
    $arr_keys = array_keys($data_array[0]);
    $header_var = $arr_keys[0];
    $row_var = $arr_keys[1];
    $val_var = $arr_keys[2];
    foreach ($data_array as $row) {
        $pivot_array[$row[$header_var]][$row[$row_var]] = h($row[$val_var]);
    }
    $row_name_keys = array_keys($data_array[0]);
    $row_name_var = $row_name_keys[0];
    $header_name_var = $row_name_keys[1];
    $pivot_name_var = $row_name_keys[2];

    $header_array = array();
    $row_array = array();
    foreach ($data_array as $key => $val) {
        if (!in_array($val[$header_name_var], $header_array)) {
            $header_array[] = h($val[$header_name_var]);
        }
        if (!in_array($val[$row_name_var], $row_array)) {
            $row_array[] = h($val[$row_name_var]);
        }
    }
    $graph_array[$header_var] = array();
    foreach ($header_array as $header) {
        $graph_array[$header] = array();
    }

    foreach ($row_array as $row) {
        $graph_array[$header_var][] = $row;
        foreach ($header_array as $header) {
            if (isset($pivot_array[$row][$header])) {
                $graph_array[$header][] = h($pivot_array[$row][$header]);
            } else {
                $graph_array[$header][] = 0;
            }
        }
    }
    $data_array2 = array();
    for ($i = 0; $i < count($graph_array[$header_var]); $i++) {
        foreach ($graph_array as $k => $v) {
            if (empty($data_array2[$i])) {
                $data_array2[$i] = array($k => $graph_array[$k][$i]);
            } else {
                $data_array2[$i] = array_merge($data_array2[$i], array($k => $graph_array[$k][$i]));
            }
        }
    }
    return $data_array2;
}

function make_graph($data, $name, $chart_type = 'spline'){
	$div_id1 = "metric-plots";
    //$axis_title = json_encode(array_keys($data), TRUE);
    $axis_title = json_encode(array_keys($data));
    $plot_data = array();
    $first_key = array_keys($data);
    $htitle = $first_key = $first_key[0];
    $name = wordwrap($name,90,'<br>');
    //print_r($data);
    $min_y = 0;
    $output = "";
    foreach ($data as $k => $v) {
        if ($k == $first_key) {
            $categories = implode(',', (array_values($v)));
        } else {
            $plot_data[] = "{
                name: '$k',
                data: [" . implode(',', array_values($v)) . "]
            }";
            $min_y = round((min($v) < $min_y) ? min($v) : $min_y,0);
            //$output .= "MIN Y TEST : $min_y \n";
            /*print_r(array_values($v));
            echo "THIS IS THE MIN  OF THE ARRAY VALUES" .min(array_values($v)) . "\n";
            echo "THIS IS THE MIN OF V". min($v) . "\n";
            echo "THIS IS MIN_Y $min_y \n";*/
        }
    }
    $plot_xml = implode(',', $plot_data);
    if (count($v) > 20) {
        $tick_interval = round(count($v) / 7);
    } else {
        $tick_interval = 1;
    }
    if ($chart_type == 'stacked_area'){
        $chart_type = 'area';
        $extra_options = "                   
         ,area: {
            'stacking':'normal'
        }";
    } else {
        $extra_options = "";
    }
    $output .= "<script type='text/javascript'>
            \$(function () {
    var chart;
   \$(document).ready(function() {
		chart = new Highcharts.Chart({
            chart: {
                renderTo: '$div_id1',
                type: 'spline',
                zoomType: 'xy',                
                marginRight: 10,
                marginBottom: 75
            },
            title: {
                text: 'Entry Count',
                x: -10
            },
            xAxis: {
                categories: [$categories],
                tickInterval: $tick_interval,
                title: {
                    text: ''
                },
                revesed: false,
            },
            yAxis: {
                title: {
                    text: ''
                },
                min: $min_y,
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            plotOptions: {
                 area: {
                    stacking: 'normal',
                    lineColor: '#ffffff',
                    lineWidth: 1,
                    marker: {
                        lineWidth: 1,
                        lineColor: '#ffffff'
                    }
                },	
                series: {
                    marker: {
                        enabled: false
                    }
                }
                $extra_options
            },
            tooltip: {
                formatter: function() {
                        return '<b>'+ this.series.name +'</b><br/>' + this.x +': '+ this.y;
                }
            },
            legend: {
                enabled: true,	
                layout: 'horizontal',
                x: -10,
                align: 'right',
                verticalAlign: 'bottom',
                borderWidth: 1,
                navigation: {
                activeColor: '#3E576F',
                animation: true,
                arrowSize: 12,
                inactiveColor: '#CCC',
                style: {
                    fontWeight: 'bold',
                    color: '#333',
                    fontSize: '12px'    
                }
            }
            },
            credits: {
                enabled: false
            },
            series: [$plot_xml]
        });	
    }); 
});
</script>";
    //$xml_array = array('body' => '<div id="' . $div_id . '" style="min-width: 700px; height: 600px; margin: 0 auto"></div>', 'header' => $output);
    $xml_array = $output;
    
    return $xml_array;

}


if (isset($_POST['table1']) === true && empty($_POST['table1']) === false
   && isset($_POST['dt1']) === true && empty($_POST['dt1']) === false
   && isset($_POST['dt2']) === true && empty($_POST['dt2']) === false) {
	require '../../connect.php';
	$link = connect('linux');
	
	if ($_POST['table1'] == 'daily') { 	
	$data_array =  run_query("select date(date) dt, symbol, count(1) records from 1day_data where date(date) >= '" .$_POST['dt1']. "' and date(date) <= '" .$_POST['dt2']. "' 
   	group by 1,2;", $link);}
   	
   	if ($_POST['table1'] == '30mins') { 	
	$data_array =  run_query("select date(date) dt, symbol, count(1) records from 30mins_data where date(date) >= '" .$_POST['dt1']. "' and date(date) <= '" .$_POST['dt2']. "' 
   	group by 1,2;", $link);}
   	
   	if ($_POST['table1'] == '5mins') { 	
	$data_array =  run_query("select date(date) dt, symbol, count(1) records from 5mins_data where date(date) >= '" .$_POST['dt1']. "' and date(date) <= '" .$_POST['dt2']. "' 
   	group by 1,2;", $link);}
	
	if ($_POST['table1'] == 'sec') { 	
	$data_array =  run_query("select date(date) dt, symbol, count(1) records from data where date(date) >= '" .$_POST['dt1']. "' and date(date) <= '" .$_POST['dt2']. "' 
   	group by 1,2;", $link);}
   	
   	
	
	$data_array = pivot($data_array);
   	try {
   		$original_key = array_keys($data_array[0]);
        $original_key = $original_key[2];
    } catch (Exception $e) {
      	// oops
        $original_key = '';
    }
	
	$graph_data = prepare_graph($data_array);
	//echo $graph_data;
	
	$qry_name = 'Entry Records';
	$graph_type = 'spline';
	$graph_output = make_graph($graph_data['graph_array'], $qry_name, $graph_type);  
	print_r($graph_output);
	mysql_close($link);
	}
?>