(function () {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation')

    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
})();


// Initiate AOS
AOS.init();

$(document).ready(function () {
    $('.loadingio').fadeOut(500);

    $('.contactForm').validate({
        rules: {
            name: {
                required: true,
            },
            email: {
                required: true,
                email: true
            },
            subject: {
                required: true
            },
            message: {
                required: true
            }
        },
        messages: {
            email: {
                required: "Please enter an email address",
                email: "Please enter a valid email address"
            },
            name: {
                required: "Please enter an name",
            },
            subject: {
                required: "Please enter an subject",
            },
            message: {
                required: "Please enter an message",
            }
        },
        submitHandler: function (form) {
            var formData = $(form).serializeArray();
            $(form).find('.btn, .submit').val('Submitting...');
            // Add a new field manually
            formData.push({ name: "form_type", value: 'ContactForm' });

            // Convert the form data to a query string
            var queryString = $.param(formData);
            // Form is valid, proceed with AJAX submission
            $.ajax({
                type: 'POST',
                url: './forms/formProcess.php',
                data: queryString,
                success: function (response) {
                    console.log(response); // You can display a success message or perform other actions
                    // let jsonRes = JSON.parse(response);
                    // Handle success response
                    if (response.emailStatus) {
                        $(form).find('.formResponse').html(`<p class="alert alert-success mb-0 p-2 mt-1">Thanks for your message, we'll be with you soon!</p>`);
                        $(form).trigger('reset');
                        $(form).find('.btn,.submit').val('Send Message');
                    }
                },
                error: function (xhr, status, error) {
                    // Handle error
                    console.error(xhr.responseText);
                    console.log('An error occurred while processing your request.');
                    $('.form-consultation .formResponse').html(`<p class="alert alert-danger mb-0 p-2 mt-1">An error occurred while processing your request.</p>`);
                    $(form).find('.btn,.submit').val('Send Message');
                }
            });
        }
    });
})