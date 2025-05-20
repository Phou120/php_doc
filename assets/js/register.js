document.addEventListener('DOMContentLoaded', function () {
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

    // Clear error states
    function clearErrors() {
        document.querySelectorAll('.form-error').forEach(el => {
            el.textContent = '';
            el.classList.add('hidden');
        });
        document.querySelectorAll('input').forEach(input => {
            input.removeAttribute('data-error');
        });
        globalError.classList.add('hidden');
    }

    function showFieldError(fieldName, message) {
        const errorElement = document.getElementById(`${fieldName}-error`);
        const inputField = document.getElementById(fieldName);
        if (errorElement && inputField) {
            errorElement.textContent = message;
            errorElement.classList.remove('hidden');
            inputField.classList.add('border-red-500');
            inputField.setAttribute('data-error', 'true');
        }
    }

    function showGlobalError(message) {
        globalErrorMessage.textContent = message;
        globalError.classList.remove('hidden');
        globalError.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function () {
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

    passwordInput.addEventListener('input', function () {
        const password = this.value;
        let strength = 0;

        const hasLength = password.length >= 8;
        document.getElementById('length-requirement').className = hasLength ? 'text-green-500' : 'text-gray-400';
        if (hasLength) strength += 1;

        const hasUppercase = /[A-Z]/.test(password);
        document.getElementById('uppercase-requirement').className = hasUppercase ? 'text-green-500' : 'text-gray-400';
        if (hasUppercase) strength += 1;

        const hasNumber = /[0-9]/.test(password);
        document.getElementById('number-requirement').className = hasNumber ? 'text-green-500' : 'text-gray-400';
        if (hasNumber) strength += 1;

        const hasSpecial = /[!@#$%^&*(),.?":{}|<>]/.test(password);
        document.getElementById('special-requirement').className = hasSpecial ? 'text-green-500' : 'text-gray-400';
        if (hasSpecial) strength += 1;

        const strengthPercent = (strength / 4) * 100;
        passwordStrength.style.width = `${strengthPercent}%`;

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

        if (confirmPasswordInput.value) checkPasswordMatch();
    });

    function checkPasswordMatch() {
        const password = passwordInput.value;
        const confirmPassword = confirmPasswordInput.value;

        if (!confirmPassword) return true;

        if (password !== confirmPassword) {
            showFieldError('confirm_password', 'ລະຫັດຜ່ານບໍ່ກົງກັນ');
            return false;
        } else {
            document.getElementById('confirm_password-error').classList.add('hidden');
            return true;
        }
    }

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

    form.addEventListener('submit', async function (e) {
        e.preventDefault();
        clearErrors();

        if (!validateForm()) {
            return;
        }

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
                const successMessage = document.createElement('div');
                successMessage.className = 'p-4 bg-green-50 text-green-700 rounded-lg border border-green-200 flex items-start mb-4';
                successMessage.innerHTML = `<i class="fas fa-check-circle mt-1 mr-3 text-green-500"></i><div>${data.message}</div>`;
                form.prepend(successMessage);

                setTimeout(() => {
                    window.location.href = data.redirect || '../../form_login.php';
                }, 1500);
            } else {
                if (data.errors) {
                    Object.keys(data.errors).forEach(field => {
                        showFieldError(field.replace('_', '-'), data.errors[field]);
                    });
                }

                showGlobalError(data.message || 'An error occurred during registration');
            }
        } catch (error) {
            console.error('Error:', error);
            showGlobalError('An unexpected error occurred. Please try again.');
        } finally {
            submitBtn.disabled = false;
            btnText.textContent = 'Sign Up';
            spinner.classList.add('hidden');
        }
    });

    document.querySelectorAll('input').forEach(input => {
        input.addEventListener('focus', function () {
            this.parentElement.classList.add('ring-2', 'ring-primary-600', 'border-transparent');
        });
        input.addEventListener('blur', function () {
            this.parentElement.classList.remove('ring-2', 'ring-primary-600', 'border-transparent');
        });
    });
});
