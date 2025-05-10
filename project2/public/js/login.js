document.addEventListener('DOMContentLoaded', function() {
    // Initialize form with error handling if needed
    initializeForm();
    
    // Set up event listeners
    setupEventListeners();
    
    // Auto-dismiss messages
    setupAutoDismiss();
});

function initializeForm() {
    // Shake form if there are errors
    if (window.appData.hasErrors) {
        const loginForm = document.getElementById('loginForm');
        loginForm.classList.add('shake');
        
        // Remove the class after animation completes
        setTimeout(() => {
            loginForm.classList.remove('shake');
        }, 500);
        
        // Focus on the first field with an error
        if (window.appData.hasEmailError) {
            document.getElementById('l1').focus();
        } else if (window.appData.hasPasswordError) {
            document.getElementById('l2').focus();
        }
    }
}

function setupEventListeners() {
    // Close error messages
    document.querySelectorAll('.error-close').forEach(btn => {
        btn.addEventListener('click', (e) => {
            closeErrorMessage(e.target.closest('.error-message'));
        });
    });

    // Close success alerts
    document.querySelectorAll('.close-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            closeSuccessAlert(e.target.closest('.alert'));
        });
    });

    // Input focus animations
    document.querySelectorAll('.input-group input').forEach(input => {
        input.addEventListener('focus', () => {
            input.parentElement.classList.add('focused');
        });
        
        input.addEventListener('blur', () => {
            input.parentElement.classList.remove('focused');
        });
    });

    // Form submission animation
    document.getElementById('loginFormElement').addEventListener('submit', function(e) {
        handleFormSubmission(this);
    });
}

function closeErrorMessage(errorMessage) {
    errorMessage.style.animation = 'errorSlideUp 0.3s forwards';
    
    setTimeout(() => {
        errorMessage.remove();
        
        // Check if there are no more error messages
        if (document.querySelectorAll('.error-message').length === 0) {
            document.getElementById('errorContainer').style.display = 'none';
        }
    }, 300);
}

function closeSuccessAlert(alert) {
    alert.style.opacity = '0';
    alert.style.transform = 'translateX(100%)';
    setTimeout(() => {
        alert.remove();
    }, 300);
}

function setupAutoDismiss() {
    // Auto-dismiss error messages after 8 seconds
    setTimeout(() => {
        document.querySelectorAll('.error-message').forEach((message, index) => {
            setTimeout(() => {
                closeErrorMessage(message);
            }, index * 200); // Stagger the dismissal
        });
    }, 8000);

    // Auto-dismiss success alerts after 5 seconds
    setTimeout(() => {
        document.querySelectorAll('.alert').forEach(alert => {
            closeSuccessAlert(alert);
        });
    }, 5000);
}

function handleFormSubmission(form) {
    const submitBtn = form.querySelector('input[type="submit"]');
    submitBtn.value = 'Connexion en cours...';
    
    // Create and add the ripple effect
    const ripple = document.createElement('span');
    ripple.classList.add('submit-ripple');
    submitBtn.appendChild(ripple);
    
    // Form will submit normally
}