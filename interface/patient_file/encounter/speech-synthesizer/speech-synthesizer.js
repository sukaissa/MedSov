if ('SpeechRecognition' in window || 'webkitSpeechRecognition' in window) {
    var recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
    recognition.continuous = true;
    recognition.interimResults = true;

    var activeTextarea = null;
    var cursorPosition = 0;

    document.querySelectorAll('textarea').forEach(function (textarea) {
        textarea.addEventListener('focus', function () {
            activeTextarea = textarea;
            cursorPosition = textarea.selectionStart;
        });

        textarea.addEventListener('input', function () {
            cursorPosition = textarea.selectionStart;
        });
    });

    recognition.onstart = function () {
      
    };

    recognition.onresult = function (event) {
        if (!activeTextarea) return;

        var interimTranscript = '';
        for (var i = event.resultIndex; i < event.results.length; i++) {
            if (event.results[i].isFinal) {
                var finalTranscript = event.results[i][0].transcript;

                var textBefore = activeTextarea.value.substring(0, cursorPosition);
                var textAfter = activeTextarea.value.substring(cursorPosition);
                activeTextarea.value = textBefore + finalTranscript + textAfter;
                cursorPosition += finalTranscript.length;

                activeTextarea.setSelectionRange(cursorPosition, cursorPosition);
            } else {
                interimTranscript += event.results[i][0].transcript;
            }
        }
    };

    recognition.onend = function () {
      
    };

    document.getElementById('startSpeech').onclick = function () {
        recognition.start();
    };

    document.getElementById('endSpeech').onclick = function () {
        recognition.stop();
    };
} else {
    alert('Speech recognition not supported by your browser.');
}
