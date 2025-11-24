/* =========================================================
   STOP jika bukan halaman login
========================================================= */
const loginForm = document.getElementById("loginForm");
if (!loginForm) {
    console.warn("login.js loaded but this page has no loginForm.");
} else {
    /* =========================================================
       ELEMENTS
    ========================================================= */
    const emailInput = document.getElementById("email");
    const passwordInput = document.getElementById("password");
    const togglePassword = document.getElementById("togglePassword");
    const loginBtn = document.getElementById("loginBtn");
    const btnText = loginBtn?.querySelector(".btn-text");
    const btnLoader = loginBtn?.querySelector(".btn-loader");

    /* =========================================================
       NOTIFICATION SYSTEM (1 notif at a time)
    ========================================================= */
    function showNotification(message, type = "error") {
        // Remove old notif
        document.querySelectorAll(".notification").forEach(n => n.remove());

        const notif = document.createElement("div");
        notif.className = `notification ${type}`;
        notif.innerHTML = `
            <i class="fas ${type === "success" ? "fa-check-circle" : "fa-exclamation-circle"}"></i>
            <span>${message}</span>
        `;

        notif.style.cssText = `
            position: fixed;
            top: 80px;
            right: 20px;
            background: white;
            padding: 12px 18px;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0,0,0,.15);
            border-left: 4px solid ${type === "success" ? "#10b981" : "#ef4444"};
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 9999;
            animation: slideIn .3s ease-out;
        `;
        
        document.body.appendChild(notif);

        setTimeout(() => {
            notif.style.animation = "slideOut .3s ease-out";
            setTimeout(() => notif.remove(), 300);
        }, 3000);
    }

    // Add animation styles
    const style = document.createElement("style");
    style.textContent = `
    @keyframes slideIn {
        from { transform: translateX(300px); opacity: 0; }
        to   { transform: translateX(0); opacity: 1; }
    }
    @keyframes slideOut {
        from { transform: translateX(0); opacity: 1; }
        to   { transform: translateX(300px); opacity: 0; }
    }
    .notification.error {
        color: #991b1b;
    }
    .notification.success {
        color: #065f46;
    }
    .notification i {
        font-size: 1.2em;
    }
    `;
    document.head.appendChild(style);

    /* =========================================================
       Password Toggle
    ========================================================= */
    function togglePasswordVisibility(input, button) {
        if (!input || !button) return;
        
        const type = input.type === "password" ? "text" : "password";
        input.type = type;

        const icon = button.querySelector("i");
        if (icon) {
            icon.classList.toggle("fa-eye");
            icon.classList.toggle("fa-eye-slash");
        }
    }

    if (togglePassword && passwordInput) {
        togglePassword.onclick = () =>
            togglePasswordVisibility(passwordInput, togglePassword);
    }

    /* =========================================================
       Validators
    ========================================================= */
    function validateEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    function validatePassword(password) {
        // Minimal 8 karakter (sesuai standar)
        return password.length >= 8;
    }

    /* =========================================================
       Clear Error Messages
    ========================================================= */
    function clearErrorMessages() {
        document.querySelectorAll('.error-message').forEach(el => {
            el.textContent = '';
        });
        document.querySelectorAll('.is-invalid').forEach(el => {
            el.classList.remove('is-invalid');
        });
    }

    /* =========================================================
       Show Field Error
    ========================================================= */
    function showFieldError(fieldId, message) {
        const field = document.getElementById(fieldId);
        if (field) {
            field.classList.add('is-invalid');
            const errorSpan = field.parentElement.querySelector('.error-message');
            if (errorSpan) {
                errorSpan.textContent = message;
            }
        }
    }

    /* =========================================================
       FINAL FORM SUBMIT HANDLER
    ========================================================= */
    loginForm.addEventListener("submit", (e) => {
        e.preventDefault(); // stop send dulu untuk validasi

        // Clear previous errors
        clearErrorMessages();
        document.querySelectorAll('.notification').forEach(n => n.remove());

        const email = emailInput?.value.trim() || '';
        const pass = passwordInput?.value || '';

        let hasError = false;

        // VALIDASI EMAIL
        if (!email) {
            showFieldError('email', 'Email wajib diisi');
            showNotification('Email wajib diisi');
            hasError = true;
        } else if (!validateEmail(email)) {
            showFieldError('email', 'Format email tidak valid');
            if (!hasError) showNotification('Format email tidak valid');
            hasError = true;
        }

        // VALIDASI PASSWORD
        if (!pass) {
            showFieldError('password', 'Password wajib diisi');
            if (!hasError) showNotification('Password wajib diisi');
            hasError = true;
        } else if (!validatePassword(pass)) {
            showFieldError('password', 'Password minimal 8 karakter');
            if (!hasError) showNotification('Password minimal 8 karakter');
            hasError = true;
        }

        // Jika ada error, stop
        if (hasError) {
            return false;
        }

        // VALID → Show loading & submit ke Laravel
        if (btnText && btnLoader && loginBtn) {
            btnText.style.display = 'none';
            btnLoader.style.display = 'inline-block';
            loginBtn.disabled = true;
        }

        // Submit form
        loginForm.submit();
    });

    /* =========================================================
       Handle Backend Errors (dari Laravel session)
    ========================================================= */
    const backendEmailError = emailInput?.getAttribute("data-backend-error");
    const backendPasswordError = passwordInput?.getAttribute("data-backend-error");

    if (backendEmailError) {
        showNotification(backendEmailError, "error");
        showFieldError("email", backendEmailError);
        window.scrollTo({ top: 0, behavior: "smooth" });
    }

    if (backendPasswordError) {
        showNotification(backendPasswordError, "error");
        showFieldError("password", backendPasswordError);
        window.scrollTo({ top: 0, behavior: "smooth" });
    }

    /* =========================================================
       Real-time Validation (Optional - untuk UX lebih baik)
    ========================================================= */
    
    // Clear error on input
    [emailInput, passwordInput].forEach(input => {
        if (input) {
            input.addEventListener('input', function() {
                this.classList.remove('is-invalid');
                const errorSpan = this.parentElement.querySelector('.error-message');
                if (errorSpan) {
                    errorSpan.textContent = '';
                }
            });
        }
    });
}

/* =========================================================
   Mobile Menu Toggle (jika ada)
========================================================= */
const mobileMenuBtn = document.getElementById('mobileMenuBtn');
const navLinks = document.getElementById('navLinks');

if (mobileMenuBtn && navLinks) {
    mobileMenuBtn.addEventListener('click', () => {
        navLinks.classList.toggle('active');
    });
}