function sendToServer(data, url) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = handleServerResponse;
    xhttp.open("POST", url, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(data);
}

var handleServerResponse = function() {
    if (this.readyState == 4 && this.status == 200) {
        var parsedRes = JSON.parse(this.responseText);
        console.log(parsedRes.status);
        if (parsedRes.status == "OK") {
            if (parsedRes.location)
                location = parsedRes.location;
            else {
                document.getElementById("error-container").innerHTML = "<p class='success'>" + parsedRes.msg + "</p>";
                var sForm = document.getElementById("signupForm");
                sForm.reset();
            }
        }
        else
            document.getElementById("error-container").innerHTML = "<p class='error'>" + parsedRes.msg + "</p>";
    }
};