<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="/js/bPopup.js"></script>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ url('/css/ticTacToe.css') }}" rel="stylesheet">
    <title>{{$key}}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script src="/js/app.js"></script>
    <script>
        if("{{$player2}}" == 'Waiting for player 2'){
            window.state = "waiting";
        }
        var channel = Echo.channel("{{$key}}");
        channel.listen('GameRoomJoin', function(data) {
            console.log(data);
            $("#player2").html(data.name);
            window.state = "ready";
        });

        channel.listen('SendMove', function(data) {
            console.log(data);
            putSymbol(data.move,data.symbol);
        });
        channel.listen('StartEvent', function(data) {
            alert(data.message + " " + data.player1 + " PLAYS FIRST");
            startGame();
        });

        var channel2 = Echo.channel("a"+"{{$id}}");
            channel2.listen('YourTurn', function(data) {
                console.log(data);
                window.move = "Mine";
                alert("MOJ POTEZ");
                if(data.player == "{{$player1}}"){
                    $("#turn").html("Your Turn");
                }
            });
            channel2.listen('NotYourTurn', function(data) {
                console.log(data);
                alert("NI MOJ POTEZ");
                window.move = "Not Mine";
                if(data.player == "{{$player1}}"){
                    $("#turn").html("Your Turn");
                }
            });
        function putSymbol(id,symbol){
            console.log(window.array);
            $("#"+id).unbind();
            $currentElement = $('#'+id);
            let child = document.createElement('h4');
            child.setAttribute('name',symbol);
            child.innerHTML = symbol;
            $currentElement.append(child);
            (window.array).splice((id.split("-")[1]) ,1);
            console.log(window.array);
        }
        function startGame(){
            startingMechancis();
        }
        function sendMove(key,move){
            if(window.move == "Mine"){
            $.ajax({
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/sendMove',
                type: 'post',
                data:{
                    'key':key,
                    'move':move,
                },
                success: function(response) {
                    console.log(response);

                }
                });
                window.move = "Not Mine";
            }else{
                alert("NI TU MOJ POTEZ");
            }
        }

        function sendStartNotif(){
            $.ajax({
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/sendStartNotif',
                type: 'post',
                data: {
                    'key':"{{$key}}",
                },
                success: function(response) {
                    console.log(response);

                }
                });
        }

        function startingMechancis(){
            window.array = [];
            $("#board").find("span").each(function () {
                window.array.push(this);
            });
            for (var i = 0; i < window.array.length; i++) {
                $(window.array[i]).click(function () {
                    sendMove("{{$key}}",this.id);
                    // putSymbol(this.id,'O');
                    console.log((this.id).split("-")[1]);
                }
                );
            }
        }
        function sendReadyNotification(){
            $.ajax({
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/sendReadyNotification',
                type: 'post',
                data: {
                    'key':"{{$key}}",
                },
                success: function(response) {
                    console.log(response);
                }
                });
        }
        $(document).ready(function () {
            $('#element_to_pop_up').bPopup({
                    onClose: function(){
                        sendReadyNotification();
                    }
                });
        });
    </script>
</head>
<body class="">
    <center>
    <h1><span id="player1">{{$player1}}</span>  vs  <span id="player2">{{$player2}}</span></h1><br />
    <h1 id="turn"></h1>
    </center>
    <div class="w-screen h-screen ctr">
        <div class="tabel ctr">
            <div class="board" id="board">
                <span id="col-0"></span>
                <span id="col-1"></span>
                <span id="col-2"></span>
                <span id="col-3"></span>
                <span id="col-4"></span>
                <span id="col-5"></span>
                <span id="col-6"></span>
                <span id="col-7"></span>
                <span id="col-8"></span>
            </div>
            <button id="reset">Reset</button>
        </div>
    </div>
    <div id="element_to_pop_up" style="display: none;" class="basic-grid">
        <h1>Are you ready</h1>
    </div>
</body>
</html>
