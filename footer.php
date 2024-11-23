<footer>
    <div class="footer-container">
        <p><strong>&copy; 2024 Nairobi Commuters Railway System. All Rights Reserved.</strong></p>
        <p><strong>Designed by Gordon Amos</strong></p>
        <div class="footer-links">
            <a href="about.php">About Us</a> | 
            <a href="contact.php">Contact</a> | 
            <a href="privacy.php">Privacy Policy</a>
        </div>
    </div>
</footer>

<style>
    body {
        margin: 0;
        display: flex;
        flex-direction: column;
        min-height: 100vh; /* Ensure the body takes up full viewport height */
    }

    main {
        flex: 1; /* Pushes the footer to the bottom if content is insufficient */
    }

    footer {
        background-color: rgba(0, 0, 0, 0.5);
        color: #fff;
        text-align: center;
        padding: 15px 0;
        position: relative;
        bottom: 0;
        width: 100%;
    }

    .footer-container {
        max-width: 500px;
        margin: 0 auto;
        padding: 0 15px;
    }

    .footer-links a {
        color: #00bfff;
        text-decoration: none;
        margin: 0 10px;
    }

    .footer-links a:hover {
        text-decoration: underline;
    }
</style>
