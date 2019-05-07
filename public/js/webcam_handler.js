var posX = 0, posY = 0, isDown = false, isReadyPicture = false, isImgChanged = false;

var currentNode = {};

function getX(){
    var w = window,
    d = document,
    e = d.documentElement,
    x = w.innerWidth || e.clientWidth || g.clientWidth,
    y = w.innerHeight|| e.clientHeight|| g.clientHeight,
    width = x / 2;
    return (width);
}


var canvas = document.querySelector('#canvas');
var imgData, error = false;

function isValidImg(file)
{
    const fileType = file["type"];
    const validImageTypes = ["image/jpeg", "image/png", "image/jpg"];
    return (validImageTypes.includes(fileType));
}

var openFile = function(event) {
    isImgChanged = true;
    var input = document.getElementById('findImg').files[0];
    var img = document.getElementById('img-display');
    var reader = new FileReader();
    var dataURL;
    reader.onload = function(e){
        dataURL = reader.result;
        if (!isValidImg(input))
            img.src = "error";
        else {
            img.src = dataURL;
            img.style.display = 'block';
        }
    };
    if (img.src !== "error")
        reader.readAsDataURL(input);
};


var addItem = false;
function createCam(x, is_resize) {

    var streaming = false,
    video        = document.querySelector('#video'),
    cover        = document.querySelector('#cover'),
    photo        = document.querySelector('#photo'),
    startbutton  = document.querySelector('#startbutton'),
    width = x,
    height = 0;

    var streamObj;

    navigator.getMedia = ( navigator.getUserMedia ||
        navigator.webkitGetUserMedia ||
        navigator.mozGetUserMedia ||
        navigator.msGetUserMedia);

        if (!navigator.getUserMedia)
        error = true;

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
                error = true;
                video.style.display = 'none';
                var input = document.getElementById('findImg');
                input.style.display = 'block';
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

        function handleError()
        {
            var data = document.getElementById('img-display');

            if (data.src == "error")
                return ;
            canvas.width = data.clientWidth;
            canvas.height = data.clientHeight;

            canvas.getContext('2d').fillStyle = "#FFF";
            canvas.getContext('2d').fillRect(0, 0, canvas.width, canvas.height);
            canvas.getContext('2d').drawImage(data, 0, 0, canvas.width, canvas.height);
            var data = canvas.toDataURL('image/png');
            canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);

            canvas.getContext('2d').drawImage(document.getElementById(currentNode.id), 0, 0, currentNode.offsetWidth, currentNode.offsetHeight);
            var item = canvas.toDataURL('image/png');

            do_xml_request('POST', '/profil/img',
            "img="+data+'&'+'item='+item+'&'+'width='+currentNode.offsetWidth+'&height='+currentNode.offsetHeight+'&posX='+posX+'&posY='+posY);
            addItem = true;
        }

        function takepicture() {
            canvas.width = width;
            canvas.height = height;
            canvas.style.display = "none";
            canvas.getContext('2d').drawImage(video, 0, 0, width, height);
            var data = canvas.toDataURL('image/png');

            canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);
            canvas.getContext('2d').drawImage(document.getElementById(currentNode.id), 0, 0, currentNode.offsetWidth, currentNode.offsetHeight);

            var item = canvas.toDataURL('image/png');
            do_xml_request('POST', '/profil/img',
            "img="+data+'&'+'item='+item+'&'+'width='+currentNode.offsetWidth+'&height='+currentNode.offsetHeight+'&posX='+posX+'&posY='+posY);
            addItem = true;
        }

        window.onload =  function () {
            startbutton.addEventListener('click', function(ev){
                if ((posX == 0 || posY == 0))
                return ;
                if (startbutton.disabled == true)
                return ;
                if (is_resize == false && error == false)
                takepicture();
                if (error == true)
                {
                    handleError();
                }
                ev.preventDefault();
            }, false);
        }
    }

    var container = document.getElementById('user-img');
    container.addEventListener('DOMNodeInserted', function(){
        setTimeout(function(){
            container.scrollTop = container.scrollHeight;
        }, 100);
    }, false);

    createCam(getX(), false);
    window.onresize = function(){
        var video = document.querySelector('#video');
        var size = getX();
        video.setAttribute('width', size);
        //canvas.setAttribute('width', size);
    };

    var startbutton  = document.querySelector('#startbutton');
    startbutton.disabled = true;

    do_xml_request('POST', '/profil/img/display', "get=1");
