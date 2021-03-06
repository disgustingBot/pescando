<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />

    <title>360 Player</title>
    <link rel="stylesheet" href="css/app.css">
</head>
<body>
<div class="controls">
    <button id="play" class="btn btn-outline-primary">
        Play
    </button>
    <button id="stop" class="btn btn-outline-danger">
        Pause
    </button>
    <button id="back" class="btn btn-outline-warning">
        Volver atrás
    </button>
</div>
<canvas id="renderCanvas" class=""></canvas>
<script type="text/javascript" src="js/app.js"></script>
<script>
$(document).ready(function() {

  $('#back').on("click", function() {
    document.location.href='botoneras.php';
  });
  
  $('#play').click();

});

</script>
</body>
</html>
