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
        cluster: 'ap1',
        forceTLS: true
    });

    //LaravelのEventクラスで設定したチャンネル名
    var channel = pusher.subscribe('my-channel');

    channel.bind('my-event', function(data) {
    //   alert(JSON.stringify(data));
        $('#messages').prepend(data.message);
    });

    //Laravelのクラス
    channel.bind('App\\Events\\PusherEvent', addMessage);

    function addMessage(data) {
        $('#messages').prepend(data.message);
    }

    function push(){
        $.get('/pusher');
    }
</script>
</body>
</html>

