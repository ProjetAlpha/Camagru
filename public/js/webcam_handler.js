var posX = 0, posY = 0, isDown = false, isReadyPicture = false;

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

    var streamObj;


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
                    streamObj = stream;
                } else {
                    var vendorURL = window.URL || window.webkitURL;
                    video.srcObject = stream;
                    streamObj = stream;
                }
                video.play();
            },
            function(err) {
                console.log("An error occured! " + err);
            }
        );
        //var stream = canvas.captureStream(25);
        //video.srcObject = stream;
        // superposer les images.
        // qd on drop : var stream = canvas.captureStream();
        // video.srcObject = stream --- pendant 5 sec, ensuite restream la cam.
        // sinon : canvas de la taille de la video + ajouter a la position de la souris l'image dans le canvas + afficher le canvas.
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

        function stopStreamedVideo(videoElem) {
            let stream = videoElem.srcObject;
            let tracks = stream.getTracks();

            tracks.forEach(function(track) {
                track.stop();
            });

            videoElem.srcObject = null;
        }

        function takepicture() {
            canvas.width = width;
            canvas.height = height;
            canvas.style.display="none";
            canvas.getContext('2d').drawImage(video, 0, 0, width, height);
            var data = canvas.toDataURL('image/png');

            canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);
            canvas.getContext('2d').drawImage(document.getElementById(currentNode.id), 0, 0, currentNode.offsetWidth, currentNode.offsetHeight);

            var item = canvas.toDataURL('image/png');
            do_xml_request('POST', '/profil/img',
            "img="+data+'&'+'item='+item+'&'+'width='+currentNode.offsetWidth+'&height='+currentNode.offsetHeight+'&posX='+posX+'&posY='+posY);
            addItem = true;
            //isReadyPicture
        }

        startbutton.addEventListener('click', function(ev){
            if (isReadyPicture == false || (posX == 0 || posY == 0))
                return ;
            if (startbutton.disabled == true)
                return ;
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

var startbutton  = document.querySelector('#startbutton');
startbutton.disabled = true;

do_xml_request('POST', '/profil/img/display', "get=1");
