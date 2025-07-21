<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
  :root {
    --primary-color: #225691;
    --secondary-color: #ff6b6b;
  }

  .floating-form-button {
    position: fixed;
    bottom: 30px;
    left: 30px;
    width: 55px;
    height: 55px;
    font-size: 22px;
    color: #fff;
    background-color: var(--primary-color);
    border: none;
    border-radius: 50%;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1050;
    transition: all 0.3s ease;
  }

  .floating-form-button:hover {
    background-color: var(--secondary-color);
    transform: scale(1.1);
  }

  .modal-content {
    border-radius: 1rem;
  }

  .form-control:focus {
    box-shadow: none;
    border-color: var(--secondary-color);
  }

  .btn-submit-inquiry {
    background-color: var(--primary-color);
    color: #fff;
    border: none;
  }

  .btn-submit-inquiry:hover {
    background-color: var(--secondary-color);
  }

  .btn-subscribe-newsletter {
    background-color: var(--secondary-color);
    color: #fff;
    border: none;
  }

  .btn-subscribe-newsletter:hover {
    background-color: #e45757;
  }

  /* Styles for validation error messages */
  .invalid-feedback {
      display: none; /* Hidden by default, shown by JS */
      color: #dc3545; /* Bootstrap's red for errors */
      font-size: 0.875em;
      margin-top: 0.25rem;
  }
  .form-control.is-invalid {
      border-color: #dc3545;
  }
</style>


<button class="btn floating-form-button d-none" id="floatingInquiryBtn" title="Contact or Subscribe">
  <i class="fas fa-envelope-open-text"></i>
</button>

<div class="modal fade" id="inquiryNewsletterModal" tabindex="-1" aria-labelledby="inquiryNewsletterModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content shadow rounded-3">
      <div class="modal-header text-white" style="background-color: #225691;">
        <h5 class="modal-title fw-bold" id="inquiryNewsletterModalLabel">Quick Inquiry & Newsletter</h5>
        <button type="button" class="close text-white" onclick="$('#inquiryNewsletterModal').modal('hide')" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body p-4">
        <div class="row">
          <div class="col-md-6 border-right">
            <h5 class="fw-bold mb-3" style="color: var(--primary-color);">Send an Inquiry</h5>
            <form id="inquiryForm" method="POST" action="{{ route('frontend.inquiry.store') }}">
              @csrf

              <div class="form-group mb-2">
                <label class="small">Full Name</label>
                <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                <div class="invalid-feedback" id="name-error"></div>
              </div>
              <div class="form-group mb-2">
                <label class="small">Phone Number</label>
                <input type="tel" name="phone" class="form-control" placeholder="+2547XXXXXXXX" required>
                <div class="invalid-feedback" id="phone-error"></div>
              </div>
              <div class="form-group mb-2">
                <label class="small">Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="you@example.com" required>
                <div class="invalid-feedback" id="email-error"></div>
              </div>
              <div class="form-group mb-2">
                <label class="small">Your Message</label>
                <textarea name="message" rows="3" class="form-control" placeholder="Ask us anything..." required></textarea>
                <div class="invalid-feedback" id="message-error"></div>
              </div>
              <button type="submit" class="btn w-100 mt-2 btn-submit-inquiry">Submit</button>
               <div class="alert alert-success mt-2 d-none" id="inquiry-success-message" role="alert"></div>
               <div class="alert alert-danger mt-2 d-none" id="inquiry-error-message" role="alert"></div>
            </form>
          </div>

          <div class="col-md-6">
            <h5 class="fw-bold mb-3" style="color: var(--secondary-color);">Subscribe</h5>
            <p class="small text-muted">Get news, course updates & event alerts directly in your inbox.</p>
            <form id="subscribeForm" method="POST" action="{{ route('frontend.newsletter.store') }}">
              @csrf
              <div class="form-group mb-3">
                <label class="small">Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="Email address" >
                <div class="invalid-feedback" id="email-subscribe-error"></div> {{-- Changed ID for clarity --}}
              </div>
              <button type="submit" class="btn w-100 btn-subscribe-newsletter">Subscribe To Newsletter</button>
              <div class="alert alert-success mt-2 d-none" id="newsletter-success-message" role="alert"></div>
              <div class="alert alert-danger mt-2 d-none" id="newsletter-error-message" role="alert"></div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Show floating button on scroll
    window.addEventListener("scroll", function () {
        const btn = document.getElementById("floatingInquiryBtn");
        if (window.scrollY > 100) {
            btn.classList.remove("d-none");
        } else {
            btn.classList.add("d-none");
        }
    });

    // Open modal on button click
    document.getElementById("floatingInquiryBtn").addEventListener("click", function () {
        $('#inquiryNewsletterModal').modal('show');
    });

    // Function to clear validation errors and general messages
    function clearFormMessages(formId) {
        $(formId).find('.is-invalid').removeClass('is-invalid');
        $(formId).find('.invalid-feedback').text('').hide();
        $(formId).find('.alert').addClass('d-none').text('');
    }

    // Function to display specific validation errors
    function displayValidationErrors(formId, errors) {
        $.each(errors, function (key, value) {
            // Find the input and add is-invalid class
            $(formId).find('[name="' + key + '"]').addClass('is-invalid');
            // Display the error message in the corresponding feedback div
            // Note: For newsletter email, using 'email-subscribe-error'
            let errorId = key + '-error';
            if (formId === '#subscribeForm' && key === 'email') {
                errorId = 'email-subscribe-error';
            }
            $(formId).find('#' + errorId).text(value[0]).show();
        });
    }

    // Inquiry Form Submission via AJAX
    $('#inquiryForm').on('submit', function (e) {
        e.preventDefault(); // Prevent default form submission

        clearFormMessages('#inquiryForm'); // Clear all previous messages/errors

        var formData = $(this).serialize(); // Serialize all form data

        $.ajax({
            url: $(this).attr('action'), // Use the form's action attribute
            method: "POST",
            data: formData,
            success: function (response) {
                if (response.success) {
                    $('#inquiry-success-message').removeClass('d-none').text(response.message || 'Inquiry submitted successfully! We will get back to you soon.');
                    $('#inquiryForm')[0].reset(); // Reset the form fields
                    // Optional: hide modal after a few seconds or allow user to close manually
                    // setTimeout(function() { $('#inquiryNewsletterModal').modal('hide'); }, 3000);
                } else {
                    // This block might be reached if controller sends success: false with a general message
                    $('#inquiry-error-message').removeClass('d-none').text(response.message || 'An unexpected error occurred. Please try again.');
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    // Validation errors
                    displayValidationErrors('#inquiryForm', xhr.responseJSON.errors);
                    $('#inquiry-error-message').removeClass('d-none').text('Please correct the highlighted errors.');
                } else {
                    // Other types of errors (e.g., server error 500, network error)
                    $('#inquiry-error-message').removeClass('d-none').text('Submission failed. An unexpected error occurred: ' + (xhr.responseJSON.message || ''));
                }
            }
        });
    });

    // Newsletter Subscription Form Submission via AJAX
    $('#subscribeForm').on('submit', function (e) {
        e.preventDefault(); // Prevent default form submission

        clearFormMessages('#subscribeForm'); // Clear all previous messages/errors

        var formData = $(this).serialize();

        $.ajax({
            url: $(this).attr('action'), // Use the form's action attribute
            method: "POST",
            data: formData,
            success: function (response) {
                if (response.success) {
                    $('#newsletter-success-message').removeClass('d-none').text(response.message || 'You have successfully subscribed to our newsletter!');
                    $('#subscribeForm')[0].reset(); // Reset the form fields
                } else {
                    $('#newsletter-error-message').removeClass('d-none').text(response.message || 'An unexpected error occurred. Please try again.');
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    // Validation errors
                    displayValidationErrors('#subscribeForm', xhr.responseJSON.errors);
                    $('#newsletter-error-message').removeClass('d-none').text('Please correct the highlighted errors.');
                } else {
                    $('#newsletter-error-message').removeClass('d-none').text('Subscription failed. An unexpected error occurred: ' + (xhr.responseJSON.message || ''));
                }
            }
        });
    });
</script>