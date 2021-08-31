<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="/js/app.js"></script>
    <script>
        var channel = Echo.channel('chat');
        channel.listen('MyEvent', function(data) {
            console.log(data);
        });
        function Test() {
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data:{
                    message: 'Join Room'
                },
                url: "/yes",
            });
        }
        function JoinRoom() {
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/joinRoom",
            });
        }
    </script>
</head>
<body>

    <button onclick="Test()">test</button>
    <button onclick="JoinRoom()">Join the room</button>

</body>
</html>
