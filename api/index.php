<?php //header("Access-Control-Allow-Origin: http://localhost");
 
require 'Slim/Slim.php';
use \Slim\Slim;
\Slim\Slim::registerAutoloader();

// import the required CRUD functions
require('../inc/crud.php');

$app = new Slim();
 

//$app->get('/service/:serviceid', 'get_records');

$app->get('/service/:serviceid/(:page_num)/(:page_rows)', function ($serviceid, $page_num, $page_rows) {
    get_service($serviceid, $page_num, $page_rows);
});

$app->run();

function get_service($serviceid, $page_num=0, $page_rows=50)
{
    // calculate the start row
    $start_row = $page_num * $page_rows;
    
    // build the sql
    $sql = get_read_sql($serviceid)
        
            // add the limit clause
            .' LIMIT '.$start_row.', '.$page_rows
        
        ;
    
	// connect to db and process the sql
	try {
		// connect to database
		$db = getConnection();

		// run the query
		$stmt = $db->query($sql);
		
		// get the values
		$posts = $stmt->fetchAll(PDO::FETCH_OBJ);

		// clear out the db resource
		$db = null;
	
		// clean up collected data
		$posts = utf8($posts);
		
        // complete the json
		$json = '{"rows": ' . json_encode($posts) . '}';

	}
    catch(PDOException $e)
    {
		$json = '{"error":{"text":'. $e->getMessage() .'}}';
    }
	// pad it
	jsonp ($json);
}

/*function get_records($serviceid)
{
    
    $sql = get_read_sql($serviceid);
    
    try {
        $db = getConnection();
        $stmt = $db->query($sql);
        $posts = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
	
		// clean up the data
		$posts = utf8($posts);
		
		$json = '{"rows": ' . json_encode($posts) . '}';
    } catch(PDOException $e) {
		$json = '{"error":{"text":'. $e->getMessage() .'}}';
    }
	// pad it
	jsonp ($json);
}*/

function getConnection() {
    $dbhost="localhost";
    $dbuser="root";
    $dbpass="";
    $dbname="db_bw_normilized_tables";

    $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
}
 
function jsonp ( $json ) {
	
	/* If a callback has been supplied then prepare to parse the callback
	 ** function call back to browser along with JSON. */
	
	$jsonp = false;
	
	if ( isset( $_GET[ 'callback' ] ) ) {
		
	 	$_GET[ 'callback' ] = strip_tags( $_GET[ 'callback' ] );
	 	$jsonp = true;
		
		$pre  = $_GET[ 'callback' ] . '(';
		$post = ');';
		
	}
	
	/* Encode JSON, and if jsonp is true, then ouput with the callback
	 ** function; if not - just output JSON. */
	print( ( $jsonp ) ? $pre . $json . $post : $json );

}

function utf8 ($data) {
	if (is_array($data))
	{
		for ($i=0; $i<count($data); $i++ )
		{
			foreach ($data[$i] as $pkey => $prow)
			{
				//if ($pkey == 'post_content')
				//{
					$data[$i]->$pkey = utf8_encode($data[$i]->$pkey);
				//}
			}
		}
	}
	else
	{
		foreach ($data as $pkey => $prow)
		{
			$data->$pkey = utf8_encode($data->$pkey);
		}
	}
	return $data;
}

?>