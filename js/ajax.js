//var xmlhttp;
//var url;

function ajax_function() {

	if (window.ActiveXObject)
    {
		xml_http = new ActiveXObject("Microsoft.XMLHTTP");
	}
    else if (window.XMLHttpRequest)
    {
		xml_http = new XMLHttpRequest();
	}
    else
    {
		alert("You are using an old browser. Please get a newer one.");
	}
	
	return xml_http;

}


function api_ajax (sid, pgnum, pgrows, selval, result_div_id, result_value, lgif_id)
{
    if (sid === undefined) sid = 'lopt_states';
    //if (selval === undefined) selval = '';
    if (result_div_id === undefined) result_div_id = 'g_tbl';
    if (result_value === undefined) result_value = 'html';
    if (lgif_id === undefined) lgif_id = 'lgif_id';
    
    
    // get the result element
	var res_div = document.getElementById(result_div_id);

    // get the loading gif
	var lgif = document.getElementById(lgif_id);
	
	// show the loading gif
    lgif.src = 'img/l.gif';
	
    // create the xmlhttp
    xml_http = ajax_function();
		
    // monitor for changes
    function stateChanged ()
    {
        if (xml_http.readyState == 4)
        {
            // display the result in the appropriate div
            switch (result_value)
            {
                case 'val':
                case 'value':
                        
                    // the result element is a text box : change the value
                    res_div.value = xml_http.responseText;
                    break;
                        
				case 'selindex':
                        
                    // the result element is a select box : change the selected index
                    res_div.options[divTo.selectedIndex].value = xml_http.responseText;
                    break;
                        
				default:
                        
                    // the html element is a  : the inner html is sent to the result
                    res_div.innerHTML += xml_http.responseText;
                        
            }
                
            // hide the loading gif
            lgif.src = 'img/dot.png';
                
        }
    }
		
    // build the url
    url = 'inc/ajax.php?sid=' + sid + '&pgnum=' + pgnum + '&pgrows=' + pgrows;
    
    xml_http.onreadystatechange = stateChanged;
    xml_http.open("GET", url, true);
    xml_http.send(null);
		
	//return xmlhttp.readyState;	
}

function gen_ajax_opt (action, selval, src, result_div_id, result_value, lgif_id)
{
    if (action === undefined) action = 'lopt_states';
    if (selval === undefined) selval = '';
    if (src === undefined) src = '';
    if (result_div_id === undefined) result_div_id = 'g_res_box';
    if (result_value === undefined) result_value = 'html';
    if (lgif_id === undefined) lgif_id = 'lgif_id';
    
    
    // get the result element
	var res_div = document.getElementById(result_div_id);

    // get the loading gif
	var lgif = document.getElementById(lgif_id);
	
	// show the loading gif
    lgif.src = 'img/l.gif';
	
    
    // create the xmlhttp
    xml_http = ajax_function();
		
		// monitor for changes
		function stateChanged ()
        {
			if (xml_http.readyState == 4)
			{
				// display the result in the appropriate div
				switch (result_value)
				{
					case 'val':
					case 'value':
                        
                        // the result element is a text box : change the value
						res_div.value = xml_http.responseText;
						break;
                        
					case 'selindex':
                        
                        // the result element is a select box : change the selected index
						res_div.options[divTo.selectedIndex].value = xml_http.responseText;
						break;
                        
					default:
                        
                        // the html element is a  : the inner html is sent to the result
						res_div.innerHTML = xml_http.responseText;
                        
				}
                
				// hide the loading gif
                lgif.src = 'img/dot.png';
                
			}
		}
		
    // build the url
    url = "inc/ajax.php?lopt=" + action + "&src=" + src + "&sval=" + selval;
    
    xml_http.onreadystatechange = stateChanged;
    xml_http.open("GET", url, true);
    xml_http.send(null);
		
	//return xmlhttp.readyState;	
}
