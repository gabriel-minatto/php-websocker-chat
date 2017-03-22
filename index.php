 <!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Websocket test site</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script type="text/javascript">

            // Edit these variables to match your environent.
            var ws_host = 'localhost';
            var ws_port = '8081';
            var ws_folder = '';
            var ws_path = '';

            // We are using wss:// as the protocol because Cloud9 is using HTTPS.
            // In case you try to run this, using HTTP, make sure to change this
            // to ws:// .
            var ws_url = 'ws://' + ws_host;
            if (ws_port != '80' && ws_port.length > 0) {
                ws_url += ':' + ws_port;
            }
            ws_url += ws_folder + ws_path;
            console.log(ws_url);
            var conn = new WebSocket(ws_url);
            conn.onopen = function(e) {
                // Spit this out in the console so we can tell if the connection
                // was successfull.
                console.log("Connection established!");
            };
            conn.onmessage = function(e) {
                // When ever a message is recieved, from the server, append
                // the message to the existing text in the chat area.
                $('#chat').append("<div class='btn btn-warning'><p style='float: left;'>"+e.data+"</p></div><br>");
            };
            
            function enviar_msg(e)
            {
                if(e.keyCode == 13)
                {
                    x = document.getElementById('msg');
                    conn.send(x.value);
                    $('#chat').append("<div class='btn btn-info'><p style='float: left;'>Eu disse: "+x.value+"</p></div><br>");
                    x.value = '';
                }
            }
            
        </script>
    </head>
    <body>
        <h1>Websocket test site</h1>
        <br>
        <hr>
        <div id="chat" style="width:500px; border:solid;"></div>
        <hr>
        <input id="msg" name="msg" type="text" size='50' onkeypress="enviar_msg(event);" autofocus></input>
        
    </body>
</html>
