document.addEventListener('scroll', function (event) {
    if (
        document.body.scrollHeight == document.body.scrollTop + window.innerHeight
    )
    {
        
        // this prevents further loading while a page is being loaded
        if (lgif_id.src.search('img/dot.png') > 0)
        {
        // if a page is not loading
        
            // make an AJAX call that will get the api
            api_ajax('airport', page_num.value, page_rows.value);
        
            // increase the page number by 1
            page_num.value++;
            
        }
    }
});

document.getElementById("see_doc_height").addEventListener("click", function (event) {
    alert(document.body.scrollHeight);
});

function gesh()
{
    alert(document.body.scrollHeight);
}