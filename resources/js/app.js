import './bootstrap';


document.addEventListener('DOMContentLoaded', (event) => {
    const passwordInput = document.getElementById('new_password');
    const confirmPasswordInput = document.getElementById('new_password_confirmation');
    const capitalLetter = document.getElementById('pwCapitalLetter');
    const oneNumber = document.getElementById('pwOneNumber');
    const specialChar = document.getElementById('pwSpecialChar');
    const eightChar = document.getElementById('pwEightchar');
    const pwMatch = document.getElementById('pwConfirmok');


    function updateCriteria(element, isValid) {
        if (isValid) {
            element.classList.add('text-success');
            element.classList.remove('text-muted');
            element.textContent = '✓ ' + element.dataset.text; // Używamy '✓'
        } else {
            element.classList.remove('text-success');
            element.classList.add('text-muted');
            element.textContent = '• ' + element.dataset.text; // Używamy '•'
        }
    }

    function checkPasswordMatch() {
        const match = passwordInput.value === confirmPasswordInput.value;
        updateCriteria(pwMatch, match);
    }

    passwordInput.addEventListener('keyup', function() {
        const value = passwordInput.value;
        const hasCapitalLetter = /[A-Z]/.test(value);
        const hasOneNumber = /[0-9]/.test(value);
        const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(value);
        const hasEightChar = value.length >= 8;

        updateCriteria(capitalLetter, hasCapitalLetter);
        updateCriteria(oneNumber, hasOneNumber);
        updateCriteria(specialChar, hasSpecialChar);
        updateCriteria(eightChar, hasEightChar);

        // Sprawdzenie wielkiej litery
        if (hasCapitalLetter) {
            capitalLetter.classList.add('text-success');
            capitalLetter.classList.add('fw-bold');
            capitalLetter.classList.remove('text-muted');
        } else {
            capitalLetter.classList.remove('text-success');
            capitalLetter.classList.remove('fw-bold');
            capitalLetter.classList.add('text-muted');
        }

        // Sprawdzenie cyfry
        if (hasOneNumber) {
            oneNumber.classList.add('text-success');
            oneNumber.classList.add('fw-bold');
            oneNumber.classList.remove('text-muted');
        } else {
            oneNumber.classList.remove('text-success');
            oneNumber.classList.remove('fw-bold');
            oneNumber.classList.add('text-muted');
        }

        // Sprawdzenie znaku specjalnego
        if (hasSpecialChar) {
            specialChar.classList.add('text-success');
            specialChar.classList.add('fw-bold');
            specialChar.classList.remove('text-muted');
        } else {
            specialChar.classList.remove('text-success');
            specialChar.classList.remove('fw-bold');
            specialChar.classList.add('text-muted');
        }

        // Sprawdzenie długości
        if (hasEightChar) {
            eightChar.classList.add('text-success');
            eightChar.classList.add('fw-bold');
            eightChar.classList.remove('text-muted');
        } else {
            eightChar.classList.remove('text-success');
            eightChar.classList.remove('fw-bold');
            eightChar.classList.add('text-muted');
        }
    });

    confirmPasswordInput.addEventListener('keyup', checkPasswordMatch);

});




// 2FA input code js
document.querySelectorAll('.code-input').forEach(function(input, idx, inputs) {
    input.addEventListener('keyup', function(e) {
        if (e.target.value.length === 1 && idx < inputs.length - 1) {
            inputs[idx + 1].focus();
        } else if (e.key === "Backspace" && idx > 0) {
            inputs[idx - 1].focus();
            inputs[idx - 1].select();
        }

        let allFilled = true;
        document.querySelectorAll('.code-input').forEach(function(input) {
            if (input.value.length === 0) {
                allFilled = false;
            }
        });

        if (allFilled) {
            let fullCode = '';
            document.querySelectorAll('.code-input').forEach(function(input) {
                fullCode += input.value;
            });
            document.getElementById('full_code').value = fullCode;

            // Odczekaj chwilę, aby upewnić się, że ostatni input zostanie zaktualizowany
            setTimeout(function() {
                document.querySelector('form').submit();
            }, 100);
        }
    });

    input.addEventListener('input', function() {
        document.getElementById('full_code').value = Array.from(inputs).map(i => i.value).join('');
    });
});



// ROLES ADDING SCRIPT
$('#addRoleForm').on('submit', function(e) {
    e.preventDefault();

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            // Zamknij modal
            $('#addRoleModal').modal('hide');

            // Odśwież listę ról
            $('#rolesTable tbody').html(response);

            // Wyświetl komunikat sukcesu
            alert('Role added successfully.');
        },
        error: function(xhr, status, error) {
            // Wyświetl komunikat błędu
            var errorMessage = xhr.status + ': ' + xhr.statusText;
            alert('Error - ' + errorMessage);
        }
    });
});


// -----

// ROLES EDIT SCRIPT
$(document).on('submit', '.editRoleForm', function(e) {
    e.preventDefault();

    $.ajax({
        url: $(this).attr('action'),
        type: 'PUT',
        data: $(this).serialize() + '&_method=PUT',
        success: function(response) {
            // Zamknij modal
            $('#editRoleModal').modal('hide');

            // Odśwież listę ról
            $('#rolesTable tbody').html(response);

            // Wyświetl komunikat sukcesu
            alert('Role edited successfully.');
        },
        error: function(xhr, status, error) {
            // Wyświetl komunikat błędu
            var errorMessage = xhr.status + ': ' + xhr.statusText;
            alert('Error - ' + errorMessage);
        }
    });
});


// -----

// ROLES DELETING SCRIPT
$(document).ready(function() {
    $('.deleteRoleForm').on('submit', function(e) {
        e.preventDefault();

        var form = $(this);
        var actionUrl = form.attr('action');

        $.ajax({
            url: actionUrl,
            type: 'POST',
            data: form.serialize(),
            success: function(result) {
                // Zamknij modal
                form.closest('.modal').modal('hide');

                // Odśwież listę ról
                location.reload(); // Lub inna logika do aktualizacji tabeli
            },
            error: function(xhr) {
                // Wyświetl komunikat błędu
                var errorMessage = xhr.status + ': ' + xhr.statusText;
                alert('Error - ' + errorMessage);
            }
        });
    });
});

// -----


// PAGINACJA TABELI PERMISSIONS
$(document).ready(function() {
    $('#permissionsTable').DataTable({
        paging: true,
        searching: false,
        ordering: false,
        info: false,
        pageLength: 10
    });
});
// -----


// PAGINACJA TABELI PERMISSIONS
$(document).ready(function() {
    $('#rolesTable').DataTable({
        paging: true,
        searching: false,
        ordering: false,
        info: false,
        pageLength: 10
    });
});

//------

$(document).ready(function() {
    $('#selectAllCheckbox').change(function() {
        if(this.checked) {
            $('.permission-checkbox').prop('checked', true);
        } else {
            $('.permission-checkbox').prop('checked', false);
        }
    });
});

$(document).ready(function() {
    $('#selectAllCheckboxCreate').change(function() {
        if(this.checked) {
            $('.permission-checkboxcreate').prop('checked', true);
        } else {
            $('.permission-checkboxcreate').prop('checked', false);
        }
    });
});



/* PHONE INPUTS JS */

function getIp(callback) {
    fetch('https://ipinfo.io/json?token=<your token>', { headers: { 'Accept': 'application/json' }})
        .then((resp) => resp.json())
        .then((data) => {
            if (data.country) {
                callback(data.country);
            } else {
                callback('pl'); // Ustaw Polskę jako kraj domyślny, jeśli nie uda się uzyskać lokalizacji za pomocą IP
            }
        })
        .catch(() => {
            callback('pl'); // Ustaw Polskę jako kraj domyślny w przypadku błędu
        });
}

// Funkcja inicjująca pole numeru telefonu
function initializePhoneInput(inputField) {
    const phoneInput = window.intlTelInput(inputField, {
        preferredCountries: ["pl", "gb"],
        initialCountry: "auto",
        geoIpLookup: getIp,
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
    });

    // Zdarzenie zmiany kraju
    inputField.addEventListener("countrychange", function() {
        const selectedCountryData = phoneInput.getSelectedCountryData();
        const dialCode = selectedCountryData.dialCode;
        phoneInput.setNumber('+' + dialCode); // Ustawienie numeru z odpowiednim prefixem
    });
}

// Znajdź wszystkie pola numeru telefonu
const phoneInputFields = document.querySelectorAll(".phone-input-field");

// Iteruj po każdym polu numeru telefonu i zainicjuj je
phoneInputFields.forEach(function(inputField) {
    initializePhoneInput(inputField);
});


/* **** */