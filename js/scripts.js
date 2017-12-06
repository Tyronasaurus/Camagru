function openTab(tabName, element) {
    var i, tabcontent, tablinks;

    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = 'none';
    }

    // Remove the background color of all tablinks/buttons
    tablinks = document.getElementsByClassName("tablink");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].style.backgroundColor = "";
    }

    // Show the specific tab content
    document.getElementById(tabName).style.display = "block";

    // Add the specific color to the button used to open the tab content
    element.style.backgroundColor = "rgba(80, 113, 128, 0.966)";
    element.style.color = "#ffffff";
    element.style.textShadow = "2px 2px #2c2c2c";
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();

// CAMERA

//--------------------
// GET USER MEDIA CODE
//--------------------
    navigator.getUserMedia = (  navigator.getUserMedia ||
                                navigator.webkitGetUserMedia ||
                                navigator.mozGetUserMedia ||
                                navigator.msGetUserMedia);

var video;
var webcamStream;


function stopWebcam() {
    webcamStream.stop();
}
//---------------------
// TAKE A SNAPSHOT CODE
//---------------------
var canvas, ctx, overlay, octx;

function init() {
    // Get the canvas and obtain a context for
    // drawing in it
    canvas = document.getElementById("myCanvas");
    overlay = document.getElementById("myOverlay");
    octx = overlay.getContext('2d');
    ctx = canvas.getContext('2d');
    if (navigator.getUserMedia) {
        navigator.getUserMedia (

        // constraints
        {
        video: true,
        audio: false
        },

        // successCallback
        function(localMediaStream) {
            video = document.querySelector('video');
            video.src = window.URL.createObjectURL(localMediaStream);
            webcamStream = localMediaStream;
        },

        // errorCallback
        function(err) {
            console.log("The following error occured: " + err);
        }
        );
    } else {
        console.log("getUserMedia not supported");
    }  
}

function snapshot() {
// Draws current image from the video element into the canvas
    var imgsrc = document.getElementById("overlay");
    overlay.width = imgsrc.width;
    overlay.height = imgsrc.height;
    canvas.width = video.width;
    canvas.height = video.height;

    imgwidth = imgsrc.width;
    imgheight = imgsrc.height;
    octx.clearRect(0, 0, imgwidth, imgheight);
    ctx.drawImage(video, 0,0, 400, 300);
    octx.drawImage(imgsrc, 0,0, imgwidth, imgheight);
}


//------------------------
//SAVE PHOTO FROM CANVAS |
//------------------------
function saveImg() {

    var sendcanv = canvas.toDataURL('image/png');
    var sendov = overlay.toDataURL('image/png');
   
    var photoshot = 'picture=' + encodeURIComponent(JSON.stringify(sendcanv)) + '&overlay=' + encodeURIComponent(JSON.stringify(sendov));
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "./cheese.php", true);
    xhttp.setRequestHeader ("Content-type", "application/x-www-form-urlencoded");

    xhttp.onreadystatechange = function () {
        console.log (this.responseText);
    }
    xhttp.send(photoshot); 
}

function changeOverlay (inpt) {
    document.getElementById("camera_button").disabled = false;
    document.getElementById("overlay").src = inpt;
    document.getElementById("overlay").style.display = "block";
}

function like (currentSource) {
    if (currentSource === "resources/like.png") {
        document.getElementById("like").src = "resources/unlike.png";
    }
    else {
        if (currentSource === "resources/unlike.png") {
            document.getElementById("like").src = "resources/like.png";
        }
    }
}