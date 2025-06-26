<!-- Floating Button -->
<button class="btn floating-form-button d-none" id="floatingInquiryBtn" title="Contact or Subscribe">
    <i class="fas fa-envelope-open-text"></i>
</button>

<!-- Inquiry & Newsletter Modal -->
<div class="modal fade" id="inquiryNewsletterModal" tabindex="-1" aria-labelledby="inquiryNewsletterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow rounded-3">
            <div class="modal-header text-white" style="background-color: var(--primary-color);">
                <h5 class="modal-title fw-bold" id="inquiryNewsletterModalLabel">Quick Inquiry & Newsletter</h5>
               <button type="button" class="btn btn-sm btn-close-modern" data-dismiss="modal" aria-label="Close">
    <i class="fas fa-times"></i>
</button>

            </div>
            <div class="modal-body p-4">
                <div class="row">
                    <!-- Inquiry Form -->
                    <div class="col-md-6 border-right">
                        <h5 class="fw-bold mb-3" style="color: var(--primary-color);">Send an Inquiry</h5>
                        <form>
                            <div class="form-group mb-2">
                                <label class="small">Full Name</label>
                                <input type="text" class="form-control" placeholder="Your Name" required>
                            </div>
                            <div class="form-group mb-2">
            <label class="small">Phone Number</label>
            <input type="tel" class="form-control" placeholder="+2547XXXXXXXX" required>
        </div>
                            <div class="form-group mb-2">
                                <label class="small">Email Address</label>
                                <input type="email" class="form-control" placeholder="you@example.com" required>
                            </div>
                            <div class="form-group mb-2">
                                <label class="small">Your Message</label>
                                <textarea rows="3" class="form-control" placeholder="Ask us anything..." required></textarea>
                            </div>
                            <button type="submit" class="btn w-100 mt-2 btn-submit-inquiry">Submit</button>
                        </form>
                    </div>

                    <!-- Newsletter Signup -->
                    <div class="col-md-6">
                        <h5 class="fw-bold mb-3" style="color: var(--secondary-color);">Subscribe</h5>
                        <p class="small text-muted">Get news, course updates & event alerts directly in your inbox.</p>
                        <form>
                            <div class="form-group mb-3">
                                <label class="small">Email Address</label>
                                <input type="email" class="form-control" placeholder="Email address" required>
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

<!-- Theming & Styles -->
<style>
    :root {
        --primary-color: #225691; /* Dark Blue */
        --secondary-color: #ff6b6b; /* Coral Red */
        --text-color: #ffffff; /* White */
        --icon-color: #ffffff; /* White icons */
    }

    /* Floating Button */
    .floating-form-button {
        position: fixed;
        bottom: 30px;
        left: 30px;
        width: 55px;
        height: 55px;
        font-size: 22px;
        color: var(--icon-color);
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

    .modal-body label,
    .modal-body h5 {
        font-family: 'Poppins', sans-serif;
        color: #222;
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

    .modal-header h5 {
        color: var(--text-color);
    }
    .btn-close-modern {
    background: transparent;
    border: none;
    color: #ffffff;
    font-size: 1.2rem;
    margin-left: auto;
    transition: color 0.3s ease;
}

.btn-close-modern:hover {
    color: #ff6b6b; /* Optional: use your secondary color */
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

</style>

<!-- Scripts -->
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

    // Modal logic
    document.getElementById("floatingInquiryBtn").addEventListener("click", function () {
        $('#inquiryNewsletterModal').modal('show');
    });

    // Form submission (demo only)
    document.querySelectorAll('#inquiryNewsletterModal form').forEach(form => {
        form.addEventListener("submit", function (e) {
            e.preventDefault();
            const success = form.querySelector('.alert-success');
            if (success) success.classList.remove('d-none');
            form.reset();
        });
    });
</script>

<!-- Bootstrap & FontAwesome (if not already loaded) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<?php /**PATH C:\Users\User\Desktop\cms\Dapin-CMS\resources\views/web/enquiry.blade.php ENDPATH**/ ?>