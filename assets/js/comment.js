let pageGenID = $(".comment_count").text()
const processUpdate = function( response ) 
{
    if ( pageGenID != response ) 
    {   
        pageGenID = response
        $(".comment_count").text(response)
        alert("Добавлен новый коментарий")
        $.ajax( {
            type: "POST",
            url: "index.php?act=commentWatchAdd&m=page",
            data: {
                companyId: getUrlParameter("id")
            },
            success: function (data) {
                $(".comment_list").append(data);
            }   
        })
    }
}

function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};
const checkUpdates = function()
{
    serverPoll = setInterval( function()
    {
        $.ajax( {
            type: "POST",
            url: "index.php?act=commentWatch&m=page",
            data: {
                companyId: getUrlParameter("id")
            },
            success: function (data) {
                processUpdate(data);
            }
        })
    }, 1000 )
};

const addComment = (companyId, userId) =>{
    const text = $(".form-control").val()
    $.ajax({
        type: "POST",
        url: "index.php?act=addComment&m=page",
        data: {
            "companyId": companyId,
            "userId": userId,
            "text": text
        },
        success: function () {
            $(".accordion-button").addClass("collapsed")
            $(".accordion-collapse").removeClass("show")
        }
    })
}

$( document ).ready( checkUpdates );