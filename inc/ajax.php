<?php

    // get the constants file
	require('constants.php');

    // get the connection
	require('conn.php');

	$api_url = API_LOC;
	
	$result = '';
	
    // the list option action command
	$sid = mysql_real_escape_string($_GET['sid']);
	$pgnum = mysql_real_escape_string($_GET['pgnum']);
	$pgrows = mysql_real_escape_string($_GET['pgrows']);
    
		switch ($sid)
        {
            case 'airport':
                    // the service url
                    $srv_url = $api_url
                        // add the service 
                        .$sid
                        // add the pagination variables
                        .'/'.$pgnum.'/'.$pgrows
                    ;
                
            // get the values from the api link
            {
                // allow for file_get_contes to run by
                // setting the PHP allwo_url_open value to 1
                ini_set("allow_url_fopen", 1);

                // get the contents of the url
                $json = file_get_contents($srv_url);

                // decode the results
                $obj = json_decode($json);
                
                // initialise the html result
                $html = '';
                
                $html .= '<tbody valign="top">';
                
                $start_row = $pgnum * $pgrows;
                //$stop_row = $start_row + $pgrows;
                
                // loop through the results
                for ($i=0; $i<count($obj->rows); $i++)
                {
            
                    $html .= ''
                        .'<tr>'
                            .'<td>'. ($start_row+$i+1) .'</td>'
                            .'<td>'. $obj->rows[$i]->airport_code .'</td>'
                            .'<td>'. $obj->rows[$i]->airport_iata_code .'</td>'
                            .'<td>'. $obj->rows[$i]->airport_desc .'</td>'
                            .'<td>'. $obj->rows[$i]->airport_city .'</td>'
                            .'<td>'. $obj->rows[$i]->airport_notes .'</td>'
                            .'<td></td>'
                        .'</tr>'
                    ;
                }
                
                $html .= '</tbody>';
                
            }
                    $result = $html;

                break;
            case 'list_airports':

                {
                    
    // build the read query
    $sql = 'SELECT * FROM `tbl_airports` WHERE 1';

    // submit the query to generate rows
    $rs = mysql_query($sql, $conn) or die(mysql_error());

    // fetch the first row
    $row = mysql_fetch_assoc($rs);

    // calculate total rows
    $total_rows = mysql_num_rows($rs);

    // initialise the html result
    $html = '';

    for ($i=0; $i<$total_rows; $i++)
    {
        // append the row 
        $html .= '<tr valign="top">'
                .'<td>'.($i+1).'</td>'
                .'<td>'.$row['airport_code'].'</td>'
                .'<td>'.$row['airport_iata_code'].'</td>'
                .'<td>'.utf8_encode($row['airport_desc']).'</td>'
                .'<td>'.utf8_encode($row['airport_city']).'</td>'
                .'<td>'.$row['airport_notes'].'</td>'
            .'</tr>'
        ;

        // load the next row
        $row = mysql_fetch_assoc($rs);

    }
                    $result = $html;
                }
                break;
			default:
				$result = 'No resource was returned!';
		}
    
	// show the result
    echo $result;

?>
