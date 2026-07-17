function openForm(formId = 'myForm') {
                const form = document.getElementById(formId);
                if (form) {
                    form.style.display = 'block';
                    document.getElementById('overlay').style.display = 'block';
                }
            }

            function closeForm(formId = 'myForm') {
                const form = document.getElementById(formId);
                if (form) {
                    form.style.display = 'none';
                }
                document.getElementById('overlay').style.display = 'none';
            }

            function rateStar(element) {
                // Get all stars in the same rating container
                const stars = element.parentElement.querySelectorAll('.fa');
                const clickedIndex = Array.from(stars).indexOf(element);
                
                // Fill all stars up to and including the clicked one
                stars.forEach((star, index) => {
                    if (index <= clickedIndex) {
                        star.classList.remove('fa-star-o');
                        star.classList.add('fa-star');
                    } else {
                        star.classList.remove('fa-star');
                        star.classList.add('fa-star-o');
                    }
                });

                const form = element.closest('form');
                const ratingInput = form ? form.querySelector('input[type="hidden"][name="rating"]') : null;
                if (ratingInput) {
                    ratingInput.value = clickedIndex + 1;
                }
            }