<!--start footer-->
<section class="footer-section bg-section-2 section-padding">
    <div class="container">
        <div class="row row-cols-1 row-cols-lg-4 g-4">
            <div class="col">
                <div class="footer-widget-6">
                    <img src="assets/images/logo.webp" class="logo-img mb-3" alt="BookHaven">
                    <h5 class="mb-3 fw-bold">About BookHaven</h5>
                    <p class="mb-2">BookHaven is the ideal destination for book lovers. We offer thousands of diverse
                        titles, from literature, science, life skills to children's books, helping you easily find the
                        most suitable book for yourself.</p>
                    <a class="link-dark" href="<?= APP_URL ?>/contact-us.php">Contact BookHaven</a>
                </div>
            </div>
            <div class="col">
                <div class="footer-widget-7">
                    <h5 class="mb-3 fw-bold">Book Categories</h5>
                    <ul class="widget-link list-unstyled">
                        <li><a href="<?= APP_URL ?>/categories.php?id=6">Literature & Arts</a></li>
                        <li><a href="<?= APP_URL ?>/categories.php?id=7">Social Sciences & Humanities</a></li>
                        <li><a href="<?= APP_URL ?>/categories.php?id=8">Natural Sciences</a></li>
                        <li><a href="<?= APP_URL ?>/categories.php?id=9">Technology & Engineering</a></li>
                        <li><a href="<?= APP_URL ?>/categories.php?id=10">Travel & Culture</a></li>
                    </ul>
                </div>
            </div>
            <div class="col">
                <div class="footer-widget-8">
                    <h5 class="mb-3 fw-bold">Information</h5>
                    <ul class="widget-link list-unstyled">
                        <li><a href="<?= APP_URL ?>/about-us.php">About BookHaven</a></li>
                        <li><a href="<?= APP_URL ?>/contact-us.php">Contact</a></li>
                        <li><a href="<?= APP_URL ?>/faq.php">FAQ</a></li>
                        <li><a href="<?= APP_URL ?>/privacy.php">Privacy Policy</a></li>
                        <li><a href="<?= APP_URL ?>/terms.php">Terms of Use</a></li>
                        <li><a href="<?= APP_URL ?>/complaints.php">Feedback & Complaints</a></li>
                    </ul>
                </div>
            </div>
            <div class="col">
                <div class="footer-widget-9">
                    <h5 class="mb-3 fw-bold">Connect with BookHaven</h5>
                    <div class="social-link d-flex align-items-center gap-2">
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-twitter"></i></a>
                        <a href="#"><i class="bi bi-linkedin"></i></a>
                        <a href="#"><i class="bi bi-youtube"></i></a>
                        <a href="#"><i class="bi bi-instagram"></i></a>
                    </div>
                    <div class="mb-4 mt-4">
                        <h5 class="mb-0 fw-bold">Support</h5>
                        <p class="mb-0 text-muted">support@bookhaven.vn</p>
                    </div>
                    <div class="">
                        <h5 class="mb-0 fw-bold">Hotline</h5>
                        <p class="mb-0 text-muted">1900-BOOK (8:00 AM - 9:00 PM)</p>
                    </div>
                </div>
            </div>
        </div>
        <!--end row-->
        <div class="my-5"></div>
        <div class="row">
            <div class="col-12">
                <div class="text-center">
                    <h5 class="fw-bold mb-3">Download the BookHaven App</h5>
                </div>
                <div class="app-icon d-flex flex-column flex-sm-row align-items-center justify-content-center gap-2">
                    <div>
                        <a href="#">
                            <img src="assets/images/play-store.webp" width="160" alt="BookHaven App">
                        </a>
                    </div>
                    <div>
                        <a href="#">
                            <img src="assets/images/apple-store.webp" width="160" alt="BookHaven App">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!--end row-->
    </div>
</section>
<!--end footer-->

<!--Start Back To Top Button-->
<a href="javaScript:;" class="back-to-top"><i class="bi bi-arrow-up"></i></a>
<!--End Back To Top Button-->

<!-- JavaScript files -->
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
<script src="assets/plugins/slick/slick.min.js"></script>
<script src="assets/js/main.js"></script>
<script src="assets/js/index.js"></script>
<script src="assets/js/loader.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!empty($_SESSION['logout_success'])): ?>
<script>
toastr.success('<?= $_SESSION['logout_success'] ?>');
</script>
<?php unset($_SESSION['logout_success']); endif; ?>
</body>

</html>