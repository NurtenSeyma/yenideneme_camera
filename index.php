<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>

  <img id="output">
  <video id="player"  autoplay></video>
  <button id="capture">Capture</button>
  <canvas id="canvas" style="display: none" width=320 height=240></canvas>
  <div id="target"></div>
  <input id="file-input" type="file" name="">
  <script>
   const fileInput = document.getElementById('file-input');
   fileInput.addEventListener('change', (e) => doSomethingWithFiles(e.target.files));
   const target = document.getElementById('target');
   target.addEventListener('drop', (e) => {
    e.stopPropagation();
    e.preventDefault();
    doSomethingWithFiles(e.dataTransfer.files);
  });
   target.addEventListener('dragover', (e) => {
    e.stopPropagation();
    e.preventDefault();
    e.dataTransfer.dropEffect = 'copy';
  });
   target.addEventListener('paste', (e) => {
    e.preventDefault();
    doSomethingWithFiles(e.clipboardData.files);
  });
   const output = document.getElementById('output');
   function doSomethingWithFiles(fileList) {
    let file = null;
    for (let i = 0; i < fileList.length; i++) {
      if (fileList[i].type.match(/^image\//)) {
        file = fileList[i];
        break;
      }
    }
    if (file !== null) {
      output.src = URL.createObjectURL(file);
    }
  }
  const supported = 'mediaDevices' in navigator;
  const player = document.getElementById('player');
  const constraints = {
    video: true,
  };
  navigator.mediaDevices.getUserMedia(constraints)
  .then((stream) => {
    player.srcObject = stream;
  });
  const canvas = document.getElementById('canvas');
  const context = canvas.getContext('2d');
  const captureButton = document.getElementById('capture');
  captureButton.addEventListener('click', () => {
    // Draw the video frame to the canvas.
    context.drawImage(player, 0, 0, canvas.width, canvas.height);
      var url = canvas.toDataURL();
      fileInput.setAttribute("value",url);
      player.style.display="none";
      canvas.style.display="block";
      console.log(url);
  });
  // Attach the video stream to the video element and autoplay.
  navigator.mediaDevices.getUserMedia(constraints)
  .then((stream) => {
    player.srcObject = stream;
  });
</script>
</body>
</html>