document.addEventListener('DOMContentLoaded', function () {
    // Toggle the visibility of the paid features section
    var upgradeBtn = document.getElementById('upgradeBtn');
    var paidFeaturesSection = document.getElementById('paidFeaturesSection');
    var closeBtn = document.getElementById('closeBtn');

    if (upgradeBtn) {
        upgradeBtn.addEventListener('click', function () {
            if (paidFeaturesSection.style.display === 'none' || paidFeaturesSection.style.display === '') {
                paidFeaturesSection.style.display = 'block'; // Show section
            } else {
                paidFeaturesSection.style.display = 'none'; // Hide section
            }
        });
    }

    // Close the paid features section
    if (closeBtn) {
        closeBtn.addEventListener('click', function () {
            paidFeaturesSection.style.display = 'none';
        });
    }

    // Other existing code...
    var languageSelect = document.getElementById('rcf7_voice_input_language');
    var customLanguageField = document.getElementById('custom_language_field');

    languageSelect.addEventListener('change', function () {
        customLanguageField.style.display = (this.value === 'custom') ? 'block' : 'none';
    });
});
