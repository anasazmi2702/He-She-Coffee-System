<?php
session_start();

if (!isset($_SESSION['user_id'])) {
header("Location: index.php");
exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>FAQ - HE & SHE Coffee</title>
<link rel="stylesheet" href="faq.css">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
</head>
<body>

<header class="navbar">
<div class="nav-container">
<div class="logo">HE&SHE COFFEE</div>
<nav>
<ul class="nav-links">
<li><a href="main.php">The Brew Welcome</a></li>
<li><a href="my_profile.php">My Profile</a></li>
<li><a href="about.php">Our Story</a></li>
<li><a href="product.php">The Coffee Bar</a></li>
<li><a href="faq.php">FAQ</a></li>
<li><a href="cart.php">Cart</a></li>
<li><a href="redeem.php">Redeem</a></li>
<li><a href="leaderboard.php">Leaderboard</a></li>
<?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
<li class="dropdown">
<a href="#" class="dropdown-btn">ADMIN</a>
<ul class="dropdown-content">
<li><a href="manage_product.php">Manage Product</a></li>
<li><a href="manage_order.php">Manage Orders</a></li>
<li><a href="manage_reward.php">Manage Rewards</a></li>
<li><a href="manage_badge.php">Manage Badges</a></li>
</ul>
</li>
<?php endif; ?>
</ul>
</nav>
<a class="logout-btn" href="index.php">Logout</a>
</div>
</header>

    <section class="faq-section">
        <div class="faq-header">
            <h1>Any Questions? We Got You.</h1>
            <p>Here are the answers to some of the most frequently asked questions about our services.</p>
        </div>
        <div class="faq-container">
            <div class="faq-item">
                <div class="faq-question">
                    <h3>How to checkout?</h3>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    <p>To checkout, add the items to your cart and click the checkout button. Follow the instructions to complete your order.</p>
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question">
                    <h3>How to pay?</h3>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    <p>You can pay using QR or cash:
                        <ul>
                            <li><strong>Cash:</strong> Please prepare a sufficient amount of money when the runner arrives to deliver the food.</li>
                            <li><strong>QR:</strong> When the runner has arrived or is on the way, please provide or show the QR to the runner.</li>
                        </ul>
                    </p>
                </div>
            </div>
			<div class="faq-item">
                <div class="faq-question">
                    <h3>How to know my order succesfully arrived?</h3>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    <p>Our runner will call you within 5 minutes before arrive to your address.</p>
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question">
                    <h3>How long does delivery take?</h3>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    <p>Delivery typically takes 15-30 minutes, depending on your location and the time of day.</p>
                </div>
            </div>
			<div class="faq-item">
                <div class="faq-question">
                    <h3>Can I pickup my order?</h3>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    <p>Your total payment will be deducted by RM 2.50 for pickup at our cafe.</p>
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question">
                    <h3>Can I cancel my order?</h3>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    <p>You can cancel your order within 5 minutes after placing it by contacting us through the "Get in Touch" form below.</p>
                </div>
            </div>
        </div>
    </section>


<section class="contact-now">
<h2>Get in Touch</h2>
<p>We’d love to hear from you! Please fill out the form below, and we’ll get in touch as soon as possible.</p>
<form id="contactForm" method="post" action="contact_handler.php">
<input type="text" name="name" id="name" placeholder="Your Name" required>
<input type="email" name="email" id="email" placeholder="Your Email" required>
<textarea name="message" id="message" placeholder="Your Message" rows="5" required></textarea>
<button type="submit">Send Message</button>
</form>
<div id="responseMessage" style="margin-top: 20px;"></div>
</section>

<footer>
<p>&copy; 2024 HE & SHE Coffee. All Rights Reserved.</p>
</footer>

<script src="faq.js"></script>
</body>
</html>
