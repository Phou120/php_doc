document.addEventListener('DOMContentLoaded', function() {
    // Form and UI elements
    const form = document.getElementById('signupForm');
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirm_password');
    const passwordStrength = document.getElementById('password-strength');
    const passwordStrengthText = document.getElementById('password-strength-text');
    const submitBtn = document.getElementById('submitBtn');
    const btnText = document.getElementById('btnText');
    const spinner = document.getElementById('spinner');
    const globalError = document.getElementById('global-error');
    const globalErrorMessage = document.getElementById('global-error-message');

    // Clear any existing error messages
    function clearErrors() {
        document.querySelectorAll('.form-error').forEach(element => {
            element.textContent = '';
            element.classList.add('hidden');
        });
        // new
        document.querySelectorAll('input').forEach(input => {
            input.removeAttribute('data-error');
        });
        globalError.classList.add('hidden');
    }

    // Show field error message
    function showFieldError(fieldName, message) {
        const errorElement = document.getElementById(`${fieldName}-error`);
        // if (errorElement) {
        //     errorElement.textContent = message;
        //     errorElement.classList.remove('hidden');

        //     // Highlight the input field
        //     const inputField = document.getElementById(fieldName);
        //     if (inputField) {
        //         inputField.classList.add('border-red-500');
        //         inputField.focus();
        //     }
        // }
        const inputField = document.getElementById(fieldName);
        if (errorElement && inputField) {
            errorElement.textContent = message;
            errorElement.classList.remove('hidden');
            inputField.classList.add('border-red-500');
            inputField.setAttribute('data-error', 'true');
        }
    }

    // Show global error message
    function showGlobalError(message) {
        globalErrorMessage.textContent = message;
        globalError.classList.remove('hidden');

        // Scroll to error
        globalError.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });
    }

    // Password visibility toggle
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.parentElement.querySelector('input');
            const icon = this.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });
    });

    // Password strength checker
    passwordInput.addEventListener('input', function() {
        const password = this.value;
        let strength = 0;

        // Length requirement
        const hasLength = password.length >= 8;
        document.getElementById('length-requirement').className = hasLength ? 'text-green-500' :
            'text-gray-400';
        if (hasLength) strength += 1;

        // Uppercase requirement
        const hasUppercase = /[A-Z]/.test(password);
        document.getElementById('uppercase-requirement').className = hasUppercase ?
            'text-green-500' : 'text-gray-400';
        if (hasUppercase) strength += 1;

        // Number requirement
        const hasNumber = /[0-9]/.test(password);
        document.getElementById('number-requirement').className = hasNumber ? 'text-green-500' :
            'text-gray-400';
        if (hasNumber) strength += 1;

        // Special character requirement
        const hasSpecial = /[!@#$%^&*(),.?":{}|<>]/.test(password);
        document.getElementById('special-requirement').className = hasSpecial ? 'text-green-500' :
            'text-gray-400';
        if (hasSpecial) strength += 1;

        // Calculate strength percentage and update UI
        const strengthPercent = (strength / 4) * 100;
        passwordStrength.style.width = `${strengthPercent}%`;

        // Update strength color and text
        if (strengthPercent < 25) {
            passwordStrength.style.backgroundColor = '#ef4444';
            passwordStrengthText.textContent = 'Weak';
            passwordStrengthText.className = 'ml-2 text-xs text-red-500';
        } else if (strengthPercent < 75) {
            passwordStrength.style.backgroundColor = '#f59e0b';
            passwordStrengthText.textContent = 'Medium';
            passwordStrengthText.className = 'ml-2 text-xs text-yellow-500';
        } else {
            passwordStrength.style.backgroundColor = '#10b981';
            passwordStrengthText.textContent = 'Strong';
            passwordStrengthText.className = 'ml-2 text-xs text-green-500';
        }

        // Check password match if confirm password has a value
        if (confirmPasswordInput.value) {
            checkPasswordMatch();
        }
    });

    // Function to check if passwords match
    function checkPasswordMatch() {
        const password = passwordInput.value;
        const confirmPassword = confirmPasswordInput.value;

        if (confirmPassword.length === 0) return;

        if (password !== confirmPassword) {
            showFieldError('confirm-password', 'ລະຫັດຜ່ານບໍ່ກົງກັນ');
            return false;
        } else {
            document.getElementById('confirm-password-error').classList.add('hidden');
            return true;
        }
    }

    // Check password match on confirm password input
    confirmPasswordInput.addEventListener('input', checkPasswordMatch);

    function validateForm() {
        let valid = true;
        const requiredFields = ['name', 'email', 'password', 'confirm_password'];

        requiredFields.forEach(fieldId => {
            const input = document.getElementById(fieldId);
            if (input && input.value.trim() === '') {
                showFieldError(fieldId, 'ກະລຸນາປ້ອນຂໍ້ມູນ');
                valid = false;
            }
        });

        // Email format validation
        const email = document.getElementById('email').value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (email && !emailRegex.test(email)) {
            showFieldError('email', 'ອີເມວບໍ່ຖືກຕ້ອງ');
            valid = false;
        }

        if (!checkPasswordMatch()) valid = false;

        return valid;
    }

    // Form submission
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        clearErrors();

        if (!validateForm()) {
            return;
        }

        // Reset input highlight
        document.querySelectorAll('input').forEach(input => {
            input.classList.remove('border-red-500');
        });

        // Validate passwords match
        if (!checkPasswordMatch()) {
            return;
        }

        // Swal.fire({
        //     title: 'Please wait...',
        //     text: 'Creating your account...',
        //     allowOutsideClick: false,
        //     allowEscapeKey: false,
        //     didOpen: () => {
        //         Swal.showLoading();
        //     }
        // });

        // Show loading state
        submitBtn.disabled = true;
        btnText.textContent = 'Creating account...';
        spinner.classList.remove('hidden');

        try {
            const formData = new FormData(form);

            const response = await fetch('../users/register.php', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const data = await response.json();

            if (response.ok && data.status === 'success') {
                // Show success message briefly before redirect
                showGlobalError = function(message) {
                    const successMessage = document.createElement('div');
                    successMessage.className =
                        'p-4 bg-green-50 text-green-700 rounded-lg border border-green-200 flex items-start mb-4';
                    successMessage.innerHTML = `
                        <i class="fas fa-check-circle mt-1 mr-3 text-green-500"></i>
                        <div>${message}</div>
                    `;

                    form.prepend(successMessage);
                };

                showGlobalError(data.message);

                // Redirect after brief delay
                setTimeout(() => {
                    window.location.href = data.redirect ||
                        '../../form_login.php';
                }, 1500);
            } else {
                // Show field-specific errors if available
                if (data.errors) {
                    Object.keys(data.errors).forEach(field => {
                        showFieldError(field.replace('_', '-'), data.errors[field]);
                    });
                }

                // Show global error message
                showGlobalError(data.message || 'An error occurred during registration');
            }
        } catch (error) {
            console.error('Error:', error);
            showGlobalError('An unexpected error occurred. Please try again.');
        } finally {
            // Reset button state
            submitBtn.disabled = false;
            btnText.textContent = 'Sign Up';
            spinner.classList.add('hidden');
        }
    });

    // Input field focus effect
    document.querySelectorAll('input').forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('ring-2', 'ring-primary-600',
                'border-transparent');
        });

        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('ring-2', 'ring-primary-600',
                'border-transparent');
        });
    });
});