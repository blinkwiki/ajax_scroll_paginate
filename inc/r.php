<?php //*********************************************READ ?>
    
    <hr>
    
    <strong>Read</strong><br><br>
    
    <?php
    
    // the service is to retrieve airport records
    $service = 'airport';
    
    // pagination
    $page_num = 0;
    $page_rows = 50;
    
    // the api url : the table deterines the service to pull from the API
    $api_url = API_LOC.$service.'/'.$page_num.'/'.$page_rows;
    
    // get the values from the api link
    {
        // allow for file_get_contes to run by
        // setting the PHP allwo_url_open value to 1
        ini_set("allow_url_fopen", 1);
        
        // get the contents of the url
        $json = file_get_contents($api_url);
        
        // decode the results
        $obj = json_decode($json);
    }
    
    
    ?>
    
    <table id="g_tbl" name="g_tbl" width="100%">
        <thead class="fw_b" valign="top">
            <tr>
                <td width="5%">SN</td>
                <td width="10%">Code</td>
                <td width="10%">IATA</td>
                <td width="35%">Airport Name</td>
                <td width="15%">Airport City</td>
                <td width="15%">Country</td>
                <td width="5%">Actions</td>
            </tr>
        </thead>
        <tbody id="page0" name="page0" valign="top">
            <?php
            // loop through the results
            //for ($i=0; $i<count($obj->rows); $i++)
            for ($i=0; $i<$page_rows; $i++)
            {
            ?>
                <tr>
                    <td><?php echo $i+1; ?></td>
                    <td><?php echo $obj->rows[$i]->airport_code; ?></td>
                    <td><?php echo $obj->rows[$i]->airport_iata_code; ?></td>
                    <td><?php echo $obj->rows[$i]->airport_desc; ?></td>
                    <td><?php echo $obj->rows[$i]->airport_city; ?></td>
                    <td><?php echo $obj->rows[$i]->airport_notes; ?></td>
                    <td>...</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <div id="page_values" align="center">
        <input type="hidden" id="page_num" name="page_num" value="<?php echo $page_num+1; ?>" />
        <input type="hidden" id="page_rows" name="page_rows" value="<?php echo $page_rows; ?>" />
        <img id="lgif_id" name="lgif_id" src="img/dot.png" width="16px" />
    </div>

<?php //*********************************************READ ?>