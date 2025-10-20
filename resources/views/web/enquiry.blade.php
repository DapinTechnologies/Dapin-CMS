<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
  :root {
    --primary-color: #225691;
    --secondary-color: #ff6b6b;
  }

  /* Floating Button Styles - Updated */
  .floating-form-button {
    position: fixed;
    bottom: 20px;
    left: 20px; /* Changed from right to left */
    width: 80px;  /* Increased size */
    height: 80px; /* Increased size */
    font-size: 32px; /* Larger icon */
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

  /* Footer Styles */
  footer {
    position: relative;
    padding: 30px 0;
    background-color: #f8f9fa;
  }

  /* Modal Styles */
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

  /* Validation Styles */
  .invalid-feedback {
    display: none;
    color: #dc3545;
    font-size: 0.875em;
    margin-top: 0.25rem;
  }

  .form-control.is-invalid {
    border-color: #dc3545;
  }
  /* Update these button styles in your CSS */
.btn-submit-inquiry {
  background-color: var(--primary-color);
  color: #fff !important; /* Force white text */
  border: none;
}

.btn-submit-inquiry:hover {
  background-color: var(--secondary-color);
  color: #fff !important; /* Keep text white on hover */
}

.btn-subscribe-newsletter {
  background-color: var(--secondary-color);
  color: #fff !important; /* Force white text */
  border: none;
}

.btn-subscribe-newsletter:hover {
  background-color: #e45757;
  color: #fff !important; /* Keep text white on hover */
}
</style>

<!-- Floating Button - Now separate from footer -->
<button class="floating-form-button" id="floatingInquiryBtn" title="Contact or Subscribe">
  <i class="fas fa-envelope-open-text"></i>
</button>

<!-- Footer Section -->
<footer class="mt-5">
  <div class="container">
    <!-- Your footer content here -->
  </div>
</footer>

<!-- Inquiry and Newsletter Modal -->
<div class="modal fade" id="inquiryNewsletterModal" tabindex="-1" aria-labelledby="inquiryNewsletterModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content shadow rounded-3">
      <div class="modal-header text-white" style="background-color: #225691;">
        <h5 class="modal-title fw-bold" id="inquiryNewsletterModalLabel">Quick Inquiry & Newsletter</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body p-4">
        <div class="row">
          <div class="col-md-6 border-right">
            <h5 class="fw-bold mb-3" style="color: var(--primary-color);">Send an Inquiry</h5>
           <form id="inquiryForm" method="POST" action="{{ url('/frontend-inquiry') }}">
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
        <input type="email" name="email" class="form-control" placeholder="your@email.com" required>
        <div class="invalid-feedback" id="email-error"></div>
    </div>
    <div class="form-group mb-3">
        <label class="small">Message</label>
        <textarea name="message" class="form-control" rows="3" placeholder="Your message..."></textarea>
    </div>
    <button type="submit" class="btn btn-primary btn-block">Submit Inquiry</button>
</form>
          </div>
          <div class="col-md-6">
            <h5 class="fw-bold mb-3" style="color: var(--secondary-color);">Subscribe</h5>
            <p class="small text-muted">Get news, course updates & event alerts directly in your inbox.</p>
            <form id="subscribeForm" method="POST" action="{{ url('/frontend-subscribe') }}">
              @csrf
              <div class="form-group mb-3">
                <label class="small">Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="Email address">
                <div class="invalid-feedback" id="email-subscribe-error"></div>
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

<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
  $(document).ready(function() {
    // Show/hide floating button based on scroll
    $(window).scroll(function() {
      const btn = $('#floatingInquiryBtn');
      if ($(this).scrollTop() > 100) {
        btn.removeClass('d-none');
      } else {
        btn.addClass('d-none');
      }
    });

    // Open modal on button click - Fixed version
    $('#floatingInquiryBtn').click(function(e) {
      e.preventDefault();
      $('#inquiryNewsletterModal').modal('show');
    });

    // Close modal when clicking the X button
    $('[data-dismiss="modal"]').click(function() {
      $('#inquiryNewsletterModal').modal('hide');
    });

    // Always show button when near footer
    function checkFooterPosition() {
      const scrollTop = $(window).scrollTop();
      const windowHeight = $(window).height();
      const documentHeight = $(document).height();
      
      if (scrollTop + windowHeight > documentHeight - 100) {
        $('#floatingInquiryBtn').removeClass('d-none');
      }
    }
    
    $(window).scroll(checkFooterPosition);
    checkFooterPosition();
  });

  
</script>