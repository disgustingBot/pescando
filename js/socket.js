
// Connexió amb el Server
var connection = new WebSocket("ws://10.39.32.10:29776");

connection.onopen = function () {
  console.log("Connection start");
};
connection.onerror = function (error) {
  console.log('Websocket error ' + error);
};
connection.onmessage = function (e) {
  if (e.data.indexOf("subProtocol") == -1) {
    var params = e.data.split(";");
    //console.log('Datos recibidos '+ e.data);
    console.log('Mensaje para ' + params[1]);
    console.log('Mi ip es ' + ipPantalla);
    if (params[1] === ipPantalla) {
      if ( params[0] == "STOP" ) {
        document.location.href='inc.session.end.php';
      } else {
        sendMessage("STARTED " + params[1]);
        $.get( "../inc.session.start.php",
          { "data": e.data },
          function (dades) {
            //console.log('Dades: '+dades);
            if ( dades != '' ) sendMessage('STOP '+dades);
            location.href = url;
        });
      }
    }
  }
}

function sendMessage(msg) {
  // Ejemplo para Acuicultura: sendMessage('PBC_animalID_LANG');
  connection.send(msg);
}

