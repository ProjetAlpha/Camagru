function getX(){
    var w = window,
    d = document,
    e = d.documentElement,
    x = w.innerWidth || e.clientWidth || g.clientWidth,
    y = w.innerHeight|| e.clientHeight|| g.clientHeight,
    width = x / 2;
    
    return (width);
}

var addItem = false;
function createCam(x, is_resize) {

    var streaming = false,
    video        = document.querySelector('#video'),
    cover        = document.querySelector('#cover'),
    canvas       = document.querySelector('#canvas'),
    photo        = document.querySelector('#photo'),
    startbutton  = document.querySelector('#startbutton'),
    width = x,
    height = 0;

    navigator.getMedia = ( navigator.getUserMedia ||
        navigator.webkitGetUserMedia ||
        navigator.mozGetUserMedia ||
        navigator.msGetUserMedia);

        navigator.getMedia(
            {
                video: true,
                audio: false
            },
            function(stream) {
                if (navigator.mozGetUserMedia) {
                    video.mozSrcObject = stream;
                } else {
                    var vendorURL = window.URL || window.webkitURL;
                    video.srcObject = stream;
                }
                video.play();
            },
            function(err) {
                console.log("An error occured! " + err);
            }
        );

        video.addEventListener('canplay', function(ev){
            if (!streaming) {
                height = video.videoHeight / (video.videoWidth/width);
                video.setAttribute('width', width);
                video.setAttribute('height', height);
                canvas.setAttribute('width', width);
                canvas.setAttribute('height', height);
                streaming = true;
            }
        }, false);

        function takepicture() {
            canvas.width = width;
            canvas.height = height;
            canvas.style.display="none";
            canvas.getContext('2d').drawImage(video, 0, 0, width, height);
            var data = canvas.toDataURL('image/png');
            do_xml_request('POST', '/profil/img', "img="+data);
            addItem = true;
        }

        startbutton.addEventListener('click', function(ev){
            if (is_resize == false)
                takepicture();
            ev.preventDefault();
        }, false);
}

var container = document.getElementById('user-img');
container.addEventListener('DOMNodeInserted', function(){
    setTimeout(function(){
        container.scrollTop = container.scrollHeight;
    }, 100);
}, false);

createCam(getX(), false);
window.onresize = function(){
    var video        = document.querySelector('#video');
    video.setAttribute('width', getX());
};

do_xml_request('POST', '/profil/img/display', "get=1");
