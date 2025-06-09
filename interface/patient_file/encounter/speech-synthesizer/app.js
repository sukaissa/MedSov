import { HfInference } from "@huggingface/inference";
const HF_TOKEN = "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";
const inference = new HfInference(HF_TOKEN);

const status = document.getElementById("status");
let activeTextarea = null;
let cursorPosition = 0;
let isRecognizing = false; // Track the speech recognition state

document.querySelectorAll('textarea').forEach(function (textarea) {
    textarea.addEventListener('focus', function () {
        activeTextarea = textarea;
        cursorPosition = textarea.selectionStart;
    });

    textarea.addEventListener('input', function () {
        cursorPosition = textarea.selectionStart;
    });
});

async function formatText(text) {
    if (!text.trim()) return;

    let formattedText = "";
    // Update the content prompt to ensure no bulleting or abnormal punctuation
    const content = `Please add basic punctuation to the following text without adding bullet points, lists, or any unnecessary formatting. Only correct for grammar and punctuation errors: ${text}`;
    
    for await (const chunk of inference.chatCompletionStream({
        model: "mistralai/Mistral-7B-Instruct-v0.3",
        messages: [
            {
                role: "user",
                content,
            },
        ],
        max_tokens: 500,
        temperature: 0,
    })) {
        if (chunk.choices && chunk.choices.length > 0) {
            formattedText += chunk.choices[0].delta.content;
            if (activeTextarea) {
                activeTextarea.value = formattedText;
                cursorPosition = formattedText.length;
                activeTextarea.setSelectionRange(cursorPosition, cursorPosition);
            }
        }
    }

    if (activeTextarea) {
        activeTextarea.value = formattedText.trim();
        cursorPosition = formattedText.trim().length;
        activeTextarea.setSelectionRange(cursorPosition, cursorPosition);
    }
    return formattedText.trim();
}


document.getElementById("formatTextButton").addEventListener("click", async () => {
    if (activeTextarea) {
        await formatText(activeTextarea.value).then(() => {});
    }
});

// Speech Recognition Code
if ('SpeechRecognition' in window || 'webkitSpeechRecognition' in window) {
    var recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
    recognition.continuous = true;
    recognition.interimResults = true;

    recognition.onstart = function () {
        isRecognizing = true;
        document.getElementById('toggleSpeech').classList.add('active');
        document.querySelector('#toggleSpeech i').classList.add('fa-microphone');
        document.querySelector('#toggleSpeech i').classList.remove('fa-microphone-slash');
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
        isRecognizing = false;
        document.getElementById('toggleSpeech').classList.remove('active');
        document.querySelector('#toggleSpeech i').classList.add('fa-microphone-slash');
        document.querySelector('#toggleSpeech i').classList.remove('fa-microphone');
    };

    document.getElementById('toggleSpeech').onclick = function () {
        if (isRecognizing) {
            recognition.stop();
        } else {
            recognition.start();
        }
    };
} else {
    alert('Speech recognition not supported by your browser.');
}

// Simulate a click on the formatTextButton every 5 seconds
setInterval(() => {
    document.getElementById("formatTextButton").click();
}, 5000);
