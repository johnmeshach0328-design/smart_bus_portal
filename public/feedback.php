<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Bus Portal | Feedback</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/CSS/custom_style.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            overflow: hidden;
            font-family: 'Inter', sans-serif;
            color: #fff;
        }

        .content-box {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            padding: 3rem;
            max-width: 600px;
            width: 90%;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.8s ease-out;
            position: relative;
            z-index: 10;
        }

        .back-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            color: rgba(255, 255, 255, 0.6);
            font-size: 1.5rem;
            transition: color 0.3s;
            text-decoration: none;
        }

        .back-btn:hover {
            color: #fff;
        }
    </style>
</head>

<body class="bg-movable bg-index bg-overlay">
    <!-- Background Animation -->
    <ul class="circles">
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
    </ul>

    <div class="content-box">
        <a href="index.php" class="back-btn"><i class="bi bi-arrow-left"></i></a>

        <div class="text-center mb-4">
            <i class="bi bi-chat-square-quote fs-1 text-success"></i>
            <h2 class="fw-bold mt-2" id="page_title">Feedback</h2>
            <p class="text-white-50" id="feed_desc">We value your thoughts! Let us know how we can improve.</p>
        </div>

        <form>
            <div class="mb-3">
                <label class="form-label text-white-50 small fw-bold text-uppercase" id="lbl_name">Your Name
                    (Optional)</label>
                <input type="text" class="form-control bg-transparent text-white border-secondary py-2"
                    placeholder="John Doe">
            </div>
            <div class="mb-4">
                <label class="form-label text-white-50 small fw-bold text-uppercase" id="lbl_msg">Your Message</label>
                <textarea class="form-control bg-transparent text-white border-secondary" rows="5" id="msg_input"
                    placeholder="Tell us what you think..."></textarea>
            </div>
            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold shadow-lg" id="btn_submit">Submit
                Feedback</button>
        </form>
    </div>

    <script src="assets/js/page-transitions.js"></script>
    <script src="assets/js/theme-manager.js"></script>
    <script src="assets/js/font-color-loader.js"></script>
    <script>
        // Form Submit Animation (Mock)
        document.querySelector('form').addEventListener('submit', (e) => {
            e.preventDefault();
            const btn = e.target.querySelector('button');
            const originalText = btn.textContent;
            btn.innerHTML = '<i class="bi bi-check-circle me-2"></i>Sent!';
            btn.classList.remove('btn-primary');
            btn.classList.add('btn-success');
            setTimeout(() => {
                btn.textContent = originalText;
                btn.classList.add('btn-primary');
                btn.classList.remove('btn-success');
                e.target.reset();
            }, 2000);
        });
    </script>
</body>

</html>