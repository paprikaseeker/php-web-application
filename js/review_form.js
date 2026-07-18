const guestReviewForm = document.getElementById('guestReviewForm');
const guestReviewMessage = document.getElementById('guestReviewMessage');
const accountReviewForm = document.getElementById('accountReviewForm');
const accountReviewMessage = document.getElementById('accountReviewMessage');

/**
 * Guest review form functions
 */
function openGuestForm() {
    const guestOverlay = document.getElementById('guestOverlay');
    const guestForm = document.getElementById('guestForm');
    if (guestOverlay) guestOverlay.style.display = 'block';
    if (guestForm) guestForm.style.display = 'block';
}

function closeGuestForm() {
    const guestOverlay = document.getElementById('guestOverlay');
    const guestForm = document.getElementById('guestForm');
    if (guestOverlay) guestOverlay.style.display = 'none';
    if (guestForm) guestForm.style.display = 'none';
}

/**
 * Account review form functions
 */
function openAccountForm() {
    if (!window.IS_LOGGED_IN) {
        openLoginPrompt();
        return;
    }

    const accountOverlay = document.getElementById('accountOverlay');
    const accountForm = document.getElementById('accountForm');
    if (accountOverlay) accountOverlay.style.display = 'block';
    if (accountForm) accountForm.style.display = 'block';
    
    // Pre-fill username if logged in
    const userNameElement = document.getElementById('accountReviewDisplayName');
    if (userNameElement && window.REVIEW_USER_NAME) {
        userNameElement.textContent = 'Logged in as: ' + window.REVIEW_USER_NAME;
    }
}

function closeAccountForm() {
    const accountOverlay = document.getElementById('accountOverlay');
    const accountForm = document.getElementById('accountForm');
    if (accountOverlay) accountOverlay.style.display = 'none';
    if (accountForm) accountForm.style.display = 'none';
}

function openLoginPrompt() {
    const overlay = document.getElementById('loginPromptOverlay');
    const prompt = document.getElementById('loginPrompt');
    if (overlay) overlay.style.display = 'block';
    if (prompt) prompt.style.display = 'block';
}

function closeLoginPrompt() {
    const overlay = document.getElementById('loginPromptOverlay');
    const prompt = document.getElementById('loginPrompt');
    if (overlay) overlay.style.display = 'none';
    if (prompt) prompt.style.display = 'none';
}

/**
 * Guest review form submission
 */
if (guestReviewForm) {
    guestReviewForm.addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(guestReviewForm);
        const rating = formData.get('rating');

        if (!rating || Number(rating) < 1) {
            guestReviewMessage.textContent = 'Please select a star rating.';
            guestReviewMessage.className = 'review-message error';
            return;
        }

        fetch(guestReviewForm.action, {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                guestReviewMessage.textContent = data.message;
                guestReviewMessage.className = 'review-message success';
                guestReviewForm.reset();
                document.getElementById('guestReviewRating').value = '0';
                const stars = document.querySelectorAll('#guestForm .star-rating .fa');
                stars.forEach(star => {
                    star.classList.remove('fa-star');
                    star.classList.add('fa-star-o');
                });
                setTimeout(() => closeGuestForm(), 2000);
            } else {
                guestReviewMessage.textContent = data.message;
                guestReviewMessage.className = 'review-message error';
            }
        })
        .catch(() => {
            guestReviewMessage.textContent = 'There was a problem submitting your review.';
            guestReviewMessage.className = 'review-message error';
        });
    });
}

/**
 * Account review form submission
 */
if (accountReviewForm) {
    accountReviewForm.addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(accountReviewForm);
        const rating = formData.get('rating');

        if (!rating || Number(rating) < 1) {
            accountReviewMessage.textContent = 'Please select a star rating.';
            accountReviewMessage.className = 'review-message error';
            return;
        }

        fetch(accountReviewForm.action, {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                accountReviewMessage.textContent = data.message;
                accountReviewMessage.className = 'review-message success';
                accountReviewForm.reset();
                document.getElementById('accountReviewRating').value = '0';
                const stars = document.querySelectorAll('#accountForm .star-rating .fa');
                stars.forEach(star => {
                    star.classList.remove('fa-star');
                    star.classList.add('fa-star-o');
                });
                setTimeout(() => closeAccountForm(), 2000);
            } else {
                accountReviewMessage.textContent = data.message;
                accountReviewMessage.className = 'review-message error';
            }
        })
        .catch(() => {
            accountReviewMessage.textContent = 'There was a problem submitting your review.';
            accountReviewMessage.className = 'review-message error';
        });
    });
}

/**
 * Star rating functions for guest form
 */
function rateGuestStar(element) {
    const parents = element.parentElement;
    const stars = parents.querySelectorAll('.fa-star-o, .fa-star');
    const clickedIndex = Array.from(stars).indexOf(element);
    
    stars.forEach((star, index) => {
        if (index <= clickedIndex) {
            star.classList.remove('fa-star-o');
            star.classList.add('fa-star');
        } else {
            star.classList.remove('fa-star');
            star.classList.add('fa-star-o');
        }
    });
    
    document.getElementById('guestReviewRating').value = clickedIndex + 1;
}

/**
 * Star rating functions for account form
 */
function rateAccountStar(element) {
    const parents = element.parentElement;
    const stars = parents.querySelectorAll('.fa-star-o, .fa-star');
    const clickedIndex = Array.from(stars).indexOf(element);
    
    stars.forEach((star, index) => {
        if (index <= clickedIndex) {
            star.classList.remove('fa-star-o');
            star.classList.add('fa-star');
        } else {
            star.classList.remove('fa-star');
            star.classList.add('fa-star-o');
        }
    });
    
    document.getElementById('accountReviewRating').value = clickedIndex + 1;
}