<!doctype html>
<html lang="hr-BA">
<head>
    <meta charset="utf-8">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="theme-color" content="#fafafa">
</head>
<body>

<script src="http://api.diu.ac/jssip-3.9.1.min.js"></script>
<script>
    // Create our JsSIP instance and run it:
    JsSIP.debug.enable('JsSIP:*');
    // var socket = new JsSIP.WebSocketInterface('wss://103.110.56.90:8089/ws');
      var socket = new JsSIP.WebSocketInterface('wss://pbx.diu.ac/ws');
    var configuration = {
        sockets: [socket],
        authorization_user: '216',
        uri: 'sip:216@pbx.diu.ac',
        ws_servers: 'wss://pbx.diu.ac:8089/ws',
        password: 'DIU216diu!@#',
        display_name: 'Md. Lemon  Patwari',
        contact_uri: 'sip:216@pbx.diu.ac'
    };
    var callOptions = {
        mediaConstraints: {
            audio: true, // only audio calls
            video: false
        }
    };
    var incomingCallAudio = new window.Audio('https://code.bandwidth.com/media/incoming_alert.mp3');
    incomingCallAudio.loop = true;
    incomingCallAudio.crossOrigin = "anonymous";
    var remoteAudio = new window.Audio();
    remoteAudio.autoplay = true;
    remoteAudio.crossOrigin = "anonymous";

    var ua = new JsSIP.UA(configuration);

    ua.on('registrationFailed', function (data) {
        alert('Registering on SIP server failed with error: ' + data.cause);
    });

    ua.on('newRTCSession', function (data) {
        console.log(data);
        console.log(data.request.headers);
        // TODO Extract diversion Diversion from

        var session = data.session;
        if (session.direction === "incoming") {
            // incoming call here
            session.on("accepted", function () {
                // the call has answered
            });
            session.on("confirmed", function () {
                var localStream = session.connection.getLocalStreams()[0];
                var dtmfSender = session.connection.createDTMFSender(localStream.getAudioTracks()[0])
                session.sendDTMF = function (tone) {
                    dtmfSender.insertDTMF(tone)
                }
            });
            session.on('peerconnection', (e) => {
                console.log('peerconnection', e);
                let logError = '';
                const peerconnection = e.peerconnection;

                peerconnection.onaddstream = function (e) {
                    console.log('addstream', e);
                    // set remote audio stream (to listen to remote audio)
                    // remoteAudio is <audio> element on pag
                    remoteAudio.srcObject = e.stream;
                    remoteAudio.play();
                };

                var remoteStream = new MediaStream();
                console.log(peerconnection.getReceivers());
                peerconnection.getReceivers().forEach(function (receiver) {
                    console.log(receiver);
                    remoteStream.addTrack(receiver.track);
                });
            });
            session.on("ended", function () {
                // the call has ended
            });
            session.on("failed", function () {
                // unable to establish the call
            });
            session.on('addstream', function (e) {
                // set remote audio stream (to listen to remote audio)
                // remoteAudio is <audio> element on page
                remoteAudio.src = window.URL.createObjectURL(e.stream);
                remoteAudio.play();
            });

            if (session.direction === 'incoming') {
                incomingCallAudio.play();
            } else {
                console.log('con', session.connection)
                session.connection.addEventListener('addstream', function (e) {
                    incomingCallAudio.pause();
                    remoteAudio.srcObject = e.stream;
                });
            }

            // Answer call
            session.answer(callOptions);

            // Reject call (or hang up it)
            // session.terminate();
        }

        //unmute call
        // session.unmute({audio: true});

        //to hangup the call
        // session.terminate();
    });


    ua.start();

</script>
</body>
</html>
