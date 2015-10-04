$map = $('#map');

function getImage(campusName)
{
    output = "";
    // I had to switch from getJSON() to ajax because of this ridiculous gotcha
    // http://stackoverflow.com/questions/18291390/jquery-getjson-syntax-error-on-a-valid-json
    //seriously...wtf??
    $.ajax({
        dataType: "json",
        url: "data/campuses.json",
        mimeType: "application/json",
        success: function(data){
            $.each(data, function(index, value)
            {
                if (value.school == campusName)
                {
                    output = "<img class='img-responsive' src='" + value.image + "' alt='" + campusName + " campus map'/>";
                    output += "<ul>";
                    output += "<li><strong>Address</strong>: "+ value.address +"</li>";
                    output += "<li><strong>Description</strong>:"+ value.description +"</li>";
                    output += "<li><strong>Website</strong>:<a href='"+ value.url + "'>"+campusName+"</a></li>";
                    output += "</ul>";
                    $map.html(output);
                }
            });
        }
    });
}