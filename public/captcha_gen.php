<?php
// Only start session if one isn't already active
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Generate random code
$chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
$captcha_code = '';
for ($i = 0; $i < 6; $i++) {
    $captcha_code .= $chars[rand(0, strlen($chars) - 1)];
}
$_SESSION['captcha_code'] = $captcha_code;

// Only send header if we are the main script (not included)
if (!headers_sent()) {
    header('Content-Type: text/html');
}
?>
<div style="
    width: 200px; 
    height: 60px; 
    background: linear-gradient(135deg, #ebf8ff 0%, #bee3f8 100%); 
    display: flex; 
    align-items: center; 
    justify-content: center; 
    border-radius: 8px; 
    position: relative; 
    overflow: hidden;
    user-select: none;
">
    <!-- Noise Lines -->
    <?php for ($i = 0; $i < 5; $i++): ?>
        <div style="
        position: absolute;
        width: 100%;
        height: 1px;
        background: rgba(66, 153, 225, 0.5);
        top: <?php echo rand(0, 60); ?>px;
        transform: rotate(<?php echo rand(-20, 20); ?>deg);
    "></div>
    <?php endfor; ?>

    <!-- Characters -->
    <?php
    $colors = ['#1e3a8a', '#1e40af', '#1d4ed8', '#2563eb'];
    for ($i = 0; $i < strlen($captcha_code); $i++):
        $rotation = rand(-20, 20);
        $font_size = rand(24, 28);
        $color = $colors[array_rand($colors)];
        $margin = rand(2, 6);
        ?>
        <span style="
        font-family: 'Courier New', monospace;
        font-weight: bold;
        font-size: <?php echo $font_size; ?>px;
        color: <?php echo $color; ?>;
        transform: rotate(<?php echo $rotation; ?>deg);
        display: inline-block;
        margin: 0 <?php echo $margin; ?>px;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        z-index: 2;
    "><?php echo $captcha_code[$i]; ?></span>
    <?php endfor; ?>
</div>