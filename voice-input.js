
document.addEventListener('DOMContentLoaded', function () {
    // Add a microphone icon to input fields with rcf7-voice-input class
document.querySelectorAll('.rcf7-voice-input').forEach(function (inputField) {
    let micButton = document.createElement('button');
    micButton.className = 'rcf7-mic-button'; // Add custom class
    micButton.innerHTML = '<span class="dashicons dashicons-microphone"></span>'; // Use Dashicons microphone icon
    micButton.type = 'button'; // Ensure it's not a submit button

        // Check if the microphone feature is disabled
        if (rcf7VoiceInput.disable) {
            micButton.classList.add('disabled');
        } else {
            micButton.addEventListener('click', function (event) {
                event.preventDefault();
                startVoiceRecognition(inputField);
            });
        }

        // Append the button inside the input field container
        let container = inputField.parentNode;
        container.style.position = 'relative'; // Ensure container has relative positioning
        container.appendChild(micButton);
    });

    function startVoiceRecognition(inputField) {
        if (!('webkitSpeechRecognition' in window)) {
            alert('Voice recognition not supported in this browser. Please use Google Chrome or Microsoft Edge.');
            return;
        }

        let recognition = new webkitSpeechRecognition();
        recognition.lang = rcf7VoiceInput.language; // Use the language from localized script
        recognition.interimResults = false;
        recognition.maxAlternatives = 1;

        recognition.onresult = function (event) {
            inputField.value = event.results[0][0].transcript;
        };

        recognition.start();
    }
});
