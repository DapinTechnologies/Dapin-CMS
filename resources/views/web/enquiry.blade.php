
<!-- Floating Button -->
<button class="btn btn-primary rounded-circle floating-form-button d-none" id="floatingInquiryBtn" title="Contact or Subscribe" data-toggle="modal" data-target="#inquiryNewsletterModal">
    <i class="fas fa-envelope-open-text"></i>
</button>

<!-- Inquiry & Newsletter Modal -->
<div class="modal fade" id="inquiryNewsletterModal" tabindex="-1" aria-labelledby="inquiryNewsletterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow rounded-3">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="inquiryNewsletterModalLabel">Quick Inquiry & Newsletter</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="row">
                    <!-- Inquiry Form -->
                    <div class="col-md-6 border-right">
                        <h5 class="fw-bold mb-3 text-primary">Send an Inquiry</h5>
                        <form>
                            <div class="form-group mb-2">
                                <label class="small text-dark">Full Name</label>
                                <input type="text" class="form-control" placeholder="Your Name" required>
                            </div>
                            <div class="form-group mb-2">
                                <label class="small text-dark">Email Address</label>
                                <input type="email" class="form-control" placeholder="you@example.com" required>
                            </div>
                            <div class="form-group mb-2">
                                <label class="small text-dark">Your Message</label>
                                <textarea rows="3" class="form-control" placeholder="Ask us anything..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 mt-2">Submit</button>
                        </form>
                    </div>

                    <!-- Newsletter Signup -->
                    <div class="col-md-6">
                        <h5 class="fw-bold mb-3 text-success">Subscribe</h5>
                        <p class="small text-muted">Get news, course updates & event alerts directly in your inbox.</p>
                        <form>
                            <div class="form-group mb-3">
                                <label class="small text-dark">Email Address</label>
                                <input type="email" class="form-control" placeholder="Email address" required>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Subscribe To Newsletter</button>
                            <div class="alert alert-success mt-2 d-none">Subscribed successfully!</div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Floating Button CSS -->
<style>
    .floating-form-button {
        position: fixed;
        bottom: 30px;
        left: 30px;
        width: 55px;
        height: 55px;
        font-size: 22px;
        z-index: 1050;
        color: #fff;
        background-color: var(--primary, #007bff);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .floating-form-button:hover {
        transform: scale(1.1);
        background-color: #0056b3;
    }

    .modal-content {
        border-radius: 1rem;
    }

    .form-control:focus {
        box-shadow: none;
        border-color: #28a745;
    }

    .modal-header h5 {
        font-family: 'Montserrat', sans-serif;
    }

    .modal-body h5,
    .modal-body label {
        font-family: 'Poppins', sans-serif;
    }
</style>

<!-- Script: Show Floating Button on Scroll -->
<script>
    window.addEventListener("scroll", function () {
        const btn = document.getElementById("floatingInquiryBtn");
        if (window.scrollY > 100) {
            btn.classList.remove("d-none");
        } else {
            btn.classList.add("d-none");
        }
    });

    // Optional: Toast message after form submission (demo only)
    document.querySelectorAll('#inquiryNewsletterModal form').forEach(form => {
        form.addEventListener("submit", function (e) {
            e.preventDefault();
            const success = form.querySelector('.alert-success');
            if (success) success.classList.remove('d-none');
            form.reset();
        });
    });
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
