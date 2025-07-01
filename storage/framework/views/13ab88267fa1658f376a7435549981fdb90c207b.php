
  <!-- Bootstrap CSS -->
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <!-- FontAwesome -->
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
  </style>


<!-- Floating Button -->
<button class="btn floating-form-button d-none" id="floatingInquiryBtn" title="Contact or Subscribe">
  <i class="fas fa-envelope-open-text"></i>
</button>

<!-- Modal -->
<div class="modal fade" id="inquiryNewsletterModal" tabindex="-1" aria-labelledby="inquiryNewsletterModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content shadow rounded-3">
      <div class="modal-header text-white" style="background-color: #225691;">
        <h5 class="modal-title fw-bold" id="inquiryNewsletterModalLabel">Quick Inquiry & Newsletter</h5>
        <!-- Manual close using JS -->
        <button type="button" class="close text-white" onclick="$('#inquiryNewsletterModal').modal('hide')" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body p-4">
        <div class="row">
          <!-- Inquiry Form -->
          <div class="col-md-6 border-right">
            <h5 class="fw-bold mb-3" style="color: var(--primary-color);">Send an Inquiry</h5>
           <form id="inquiryForm" method="POST">
  <?php echo csrf_field(); ?>
              <div class="form-group mb-2">
                <label class="small">Full Name</label>
                <input type="text" name="name" class="form-control" placeholder="Your Name" required>

              </div>
              <div class="form-group mb-2">
                <label class="small">Phone Number</label>
                <input type="tel" name="phone" class="form-control" placeholder="+2547XXXXXXXX" required>
              </div>
              <div class="form-group mb-2">
                <label class="small">Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="you@example.com" required>
              </div>
              <div class="form-group mb-2">
                <label class="small">Your Message</label>
                <textarea name="message" rows="3" class="form-control" placeholder="Ask us anything..." required></textarea>
              </div>
              <button type="submit" class="btn w-100 mt-2 btn-submit-inquiry">Submit</button>
            </form>
          </div>

          <!-- Newsletter Signup -->
          <div class="col-md-6">
            <h5 class="fw-bold mb-3" style="color: var(--secondary-color);">Subscribe</h5>
            <p class="small text-muted">Get news, course updates & event alerts directly in your inbox.</p>
           <form id="subscribeForm" method="POST">
  <?php echo csrf_field(); ?>
              <div class="form-group mb-3">
                <label class="small">Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="Email address" >
              </div>
              <button type="submit" class="btn w-100 btn-subscribe-newsletter">Subscribe To Newsletter</button>
              <div class="alert alert-success mt-2 d-none">Subscribed successfully!</div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- JS Libraries -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Modal and Form Logic -->
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

  // Fake form submission (demo)
  document.querySelectorAll('#inquiryNewsletterModal form').forEach(form => {
    form.addEventListener("submit", function (e) {
      e.preventDefault();
      const success = form.querySelector('.alert-success');
      if (success) success.classList.remove('d-none');
      form.reset();
    });
  });
</script>

<script>
  $('#inquiryForm').on('submit', function (e) {
    e.preventDefault();

    $.ajax({
      url: "<?php echo e(route('frontend.inquiry.store')); ?>",
      method: "POST",
      data: {
        _token: '<?php echo e(csrf_token()); ?>',
        name: $('input[name="name"]').val(),
        phone: $('input[name="phone"]').val(),
        email: $('input[name="email"]').val(),
        message: $('textarea[name="message"]').val()
      },
      success: function (response) {
        alert('Inquiry submitted successfully');
        $('#inquiryForm')[0].reset();
        $('#inquiryNewsletterModal').modal('hide');
      },
      error: function (xhr) {
        alert('Submission failed. Please check your input.');
      }
    });
  });

  $('#subscribeForm').on('submit', function (e) {
    e.preventDefault();

    $.ajax({
      url: "<?php echo e(route('frontend.newsletter.store')); ?>",
      method: "POST",
      data: {
        _token: '<?php echo e(csrf_token()); ?>',
        email: $('form#subscribeForm input[name="email"]').val()
      },
      success: function (response) {
        alert('Subscribed successfully!');
        $('#subscribeForm')[0].reset();
      },
      error: function (xhr) {
        alert('Email already subscribed or invalid.');
      }
    });
  });
  error: function (xhr) {
  if (xhr.status === 422) {
    let errors = xhr.responseJSON.errors;
    let messages = Object.values(errors).flat().join('\n');
    alert('Validation Errors:\n' + messages);
  } else {
    alert('Unexpected Error. Status: ' + xhr.status);
  }
}

</script>


<?php /**PATH C:\Users\User\Desktop\cms\Dapin-CMS\resources\views/web/enquiry.blade.php ENDPATH**/ ?>