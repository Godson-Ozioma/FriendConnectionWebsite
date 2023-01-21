
console.log("search connected");


/**
 * Send and receive friend request in real time
 * use of HttpRequest
 */
function liveFriendRequest(){
    console.log("live request called");
    let w = new WebRequest();//create an instance of the WebRequest() class
    w.getXMLHttpRequest().onreadystatechange = function (){
        //success and failure codes
        if (w.isValid()){
            console.log("lfr:" + JSON.parse(w.getXMLHttpRequest().responseText));
            let response = JSON.parse(w.getXMLHttpRequest().responseText);
            let liveRequestDiv = document.getElementById('live_request');
            let liveRequestDivBody = "";
            //display the response of the request sent and returns it in a card and it is concartinated using the json format
            response.forEach(function (obj){
                liveRequestDivBody +=
                    "<div class=\"col-sm-4 col-lg-3 p-3\">" +
                        "<div class=\"card\">" +
                            "<div class='card-body text-center'>" +
                                "<p class='card-text'>" + obj.name + "</p>" +
                                "<p class='card-text'>" + obj.username + "</p>" +
                                "<p class='card-text'>" + "<img src=" +"'" + obj.profilePicture + "'" + "/>" + "</p>" +
                                "<a href=" + "'request.php?accept_user_id=" + obj.userID + "'" + ">Accept</a>" +
                                "<a href=" + "'request.php?reject_user_id=" + obj.userID + "'" + ">Reject</a>" +
                            "</div>" +
                        "</div>" +
                    "</div>"

                    // ""


            });

            liveRequestDiv.innerHTML = liveRequestDivBody;
        }
    }

    w.getXMLHttpRequest().open('GET', 'request.php?live_request=true');
    w.getXMLHttpRequest().send(null);
}


/**
 * function to control the live search by bringing out search result while the user is typing
 * Makes use of Xml and JSON
 *
 */
function liveSearch(searchText)
{
    console.log(searchText);

    let w = new WebRequest();

    w.getXMLHttpRequest().onreadystatechange = function (){
        //success and failure codes
        if (w.isValid())
        {
            //creates an initial empty array for the live search results
            let result = [];
            //converts the JSON string to a JavaScript object
            result = JSON.parse(w.getXMLHttpRequest().responseText);

            let liveSearchDivBody = ""; // LIVE SEARCH UI
            let liveSearchDiv = document.getElementById("live_search_result");


            // Displaying the live search results in a card form
            result.forEach(function (obj){
                liveSearchDivBody +=
                    "<div class='col-sm-4 col-lg-3 p-3'>" +
                    "<div class='card'>" +
                    "<img class='card-img-top text-center' src=" + "'" + obj.profilePicture + "'" + "alt='profileImg'>" +
                    "<div class='card-body text-center'>" +
                    "<p class='card-text'>" + obj.username + "</p>" +
                    "<p class='card-text'>" + obj.name + "</p>" +
                    "</div>" +
                    "</div>" +
                    "</div>";
                console.log("username: " + obj.username);
            });

            liveSearchDiv.innerHTML = liveSearchDivBody;

            // console.log('responseText: ' + JSON.parse( xhr.responseText));
        }
    }
        // open and send the live search command for the key that has been pressed
    w.getXMLHttpRequest().open('GET', 'search.php?live_search=' + searchText);//connects to the php
    w.getXMLHttpRequest().send(null);
}

//function for the methods for the live request
function queue(){
    liveFriendRequest();
    // liveLocation();
    // clearFeatures();
    // map.removeLayer(vectorLayer);
}

//refreshes the friend request every 2 seconds and when a new request is given, it authomatically comes up
document.addEventListener('DOMContentLoaded', function (){
    const interval = setInterval(queue, 2000);//interval between each refresher
});







