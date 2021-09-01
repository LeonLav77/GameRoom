<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ url('/css/ticTacToe.css') }}" rel="stylesheet">
    <title>{{$key}}</title>
    <script src="/js/app.js"></script>
    <script>
        var channel = Echo.channel("{{$key}}");
        channel.listen('GameRoomJoin', function(data) {
            console.log(data);
        });
        function putX(id){
            console.log(window.array);
            $currentElement = $('#'+id);
            let child = document.createElement('h1');
            child.setAttribute('name','X');
            child.innerHTML = 'X';
            $currentElement.append(child);
            // $currentElement.text('X');
        }
        $(document).ready(function(){
            window.array = [];
            $('span').each(function () {
                window.array.push(this);
            });
            for (var i = 0; i < window.array.length; i++) {
                $(window.array[i]).click(function () {
                    putX((this.id));
                    console.log((this.id).split("-")[1]);
                }
                );
            }
            putX();
        });
    </script>
</head>
<body class="">
    <center>
    <h1>{{$player1}}  vs  {{$player2}}</h1><br />
    </center>
    <div class="w-screen h-screen ctr">
        <div class="tabel ctr">
            <div class="board">
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
</body>
</html>
