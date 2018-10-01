<!DOCTYPE html>
<html>
<head>
    <title>Pusher</title>
</head>
<body>
<input type="button" value="push" onclick='push()'>
<ul id="messages"></ul>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://js.pusher.com/3.1/pusher.min.js"></script>
<script>
    //Pusherキー
    var pusher = new Pusher( '{{ env('PUSHER_APP_KEY') }}' , {
        encrypted: true
    });

    //LaravelのEventクラスで設定したチャンネル名
    var channel = pusher.subscribe('my-channel');

    //Laravelのクラス
    channel.bind('App\\Events\\PullcardDetection', addMessage);

    function addMessage(data) {
        $('#messages').prepend(data.card);
    }

    function push(){
        $.get('/pullcard2');
    }
</script>
</body>
</html>