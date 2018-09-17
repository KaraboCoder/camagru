var s_image = null;
imageTobeRemoved = null;

function uploadFile(data) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = handleServerResponse;
    xhttp.open("POST", "functions/uploadfiles.php", true);
    xhttp.send(data);
}

function deleteImageFromServer(data) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = handleDeleteResponse;
    xhttp.open("POST", "functions/deleteimage.php", true);
    xhttp.send(data);
}

var handleDeleteResponse = function() {
    if (this.readyState == 4 && this.status == 200) {
        imageTobeRemoved.remove();
        var parsedRes = JSON.parse(this.responseText);
        if (parsedRes.status == "OK") {
            alert("Image removed");
        }else{
         alert("Error: Could not process your request");
        }
    }
}

var handleServerResponse = function() {
    if (this.readyState == 4 && this.status == 200) {
        console.log(this.responseText);
        var parsedRes = JSON.parse(this.responseText);
        console.log(parsedRes.status);
        if (parsedRes.status == "OK") {
            var sidebar = document.getElementById("side-bar");
            var newLink = document.createElement("div");
            var linkContainer= document.createElement("div");
            linkContainer.classList.add("side-bar-link-container");
            newLink.classList.add("side-bar-link");
            newLink.href = "viewimage.php/?image=" + parsedRes.url;
            var deleteBtn = document.createElement("button");
            deleteBtn.dataset.url = parsedRes.url;
            deleteBtn.classList.add("delete-btn");
            deleteBtn.innerText = "Delete";
            deleteBtn.addEventListener("click", deleteImage);
            var newImage = document.createElement("img");
            newImage.classList.add("side-bar-img");
            newImage.src = parsedRes.url;
            newLink.appendChild(newImage);
            linkContainer.appendChild(newLink);
            linkContainer.appendChild(deleteBtn)
            sidebar.prepend(linkContainer);
        }
        else
            alert("Error:Could not process your request");
    }
};

var deleteImage = function(){
    var formData = new FormData(document.forms[1]);
    formData.append("url", this.dataset.url)
    imageTobeRemoved = this.parentElement;
    deleteImageFromServer(formData);
}

document.querySelectorAll(".delete-btn").forEach(function(element, index){
    element.addEventListener("click", deleteImage);
});

document.querySelectorAll(".s-image").forEach(function(element, index){
    element.addEventListener("click", function(e){
        oldImage = document.getElementsByClassName("absolute-position")[0];
        if (oldImage) oldImage.remove();
        var superposable = e.target.cloneNode(true);
        superposable.classList.add("absolute-position");
        superposable.style.top = document.getElementById("cam").offsetTop + 30 + "px";
        superposable.style.left = document.getElementById("cam").offsetLeft + "px";
        document.getElementById("cam-wrapper").appendChild(superposable);
        document.getElementById("capture").disabled = false;
        s_image = {
            "url": superposable.getAttribute("data-url"),
            "h": superposable.offsetHeight,
            "w": superposable.offsetWidth
        };
        console.log(JSON.stringify(s_image));
    });
});

window.onload = function(){

    if (navigator.getUserMedia)
    {
        navigator.getUserMedia({audio:false, video:true},
            function(media){
            document.getElementById("cam").src = window.URL.createObjectURL(media);
            document.getElementById("capture").addEventListener("click", function(){
                document.getElementById("canvas").getContext("2d").drawImage(document.getElementById("cam"),0,0,200,200);
                var formData = new FormData(document.forms[0]);
                document.getElementById("canvas").toBlob(function(capturedImage){
                    formData.append("capturedImage", capturedImage);
                    if (s_image) formData.append("image", JSON.stringify(s_image));
                    uploadFile(formData);
                });
                
            });
        },function(error){
          alert(error.message);  
        });
    }
};