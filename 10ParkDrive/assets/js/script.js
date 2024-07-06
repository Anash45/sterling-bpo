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

    // Register Form
    $('.registerForm').validate({
        rules: {
            first_name: {
                required: true,
            },
            last_name: {
                required: true,
            },
            email: {
                required: true,
                email: true,
            },
            phone: {
                required: true,
                // Add additional phone validation rules if needed
            },
            working_with_realtor: {
                required: true,
            },
            brokerage: {
                required: true,
            },
            'contact_method[]': {
                required: true,
            },
            interested_in: {
                required: true,
            },
            heard_about_us: {
                required: true,
            }
        },
        messages: {
            first_name: {
                required: "Please enter a first name",
            },
            last_name: {
                required: "Please enter a last name",
            },
            email: {
                required: "Please enter an email address",
                email: "Please enter a valid email address",
            },
            phone: {
                required: "Please enter a valid phone number",
            },
            working_with_realtor: {
                required: "Please select if you are working with a realtor",
            },
            brokerage: {
                required: "Please select your brokerage",
            },
            'contact_method[]': {
                required: "Please select at least one contact method",
            },
            interested_in: {
                required: "Please select what you are interested in",
            },
            heard_about_us: {
                required: "Please select how you heard about us",
            }
        },
        errorElement: 'div',
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            element.closest('.mb-5').append(error);
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass('is-invalid').removeClass('is-valid');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass('is-invalid').addClass('is-valid');
        },
        submitHandler: function (form) {
            var formData = $(form).serializeArray();
            $(form).find('.btn, .submit').val('Submitting...');
            // Add a new field manually
            formData.push({ name: "form_type", value: 'RegisterForm' });

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
