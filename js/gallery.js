var likeBtn = null;

function sendDataToServer(data, url) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = handleDeleteResponse;
    xhttp.open("GET", url + "/?" + "photoid=" + data.photoid + "&uid=" + data.uid, true);
    xhttp.send();
}

var handleDeleteResponse = function() {
    if (this.readyState == 4 && this.status == 200) {
        console.log(this.responseText);
        var parsedRes = JSON.parse(this.responseText);
        if (parsedRes.status == "OK") {
            if (parsedRes.action == "likes")
            {
                likeBtn.innerText = "Likes (" + parsedRes.count + ")";
            }
        }else{
         alert("Error: Could not process your request");
        }
    }
}

/***************************
*   HANDLE LIKES
****************************/

var handleLikes = function(e){
    var photoid = this.dataset.photoid;
    var uid = this.dataset.uid;
    likeBtn = this;
    sendDataToServer({"photoid": photoid, "uid": uid}, "functions/likes.php");
}

document.querySelectorAll(".likes").forEach(function(photo, index){
    photo.addEventListener("click", handleLikes);
});

document.querySelectorAll(".view-comments").forEach(function(photo, index){
    photo.addEventListener("click", function(){
        var photoid = this.dataset.photoid;
        window.location = "comments.php?photoid=" + photoid;
    });
});