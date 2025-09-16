<?php
if (!defined('ABSPATH')) {
    exit;
}
?>

<div id="terminal-wrapper">
    <div id="terminal">
        <div class="terminal-header">
            <div class="terminal-circle terminal-red"></div>
            <div class="terminal-circle terminal-yellow"></div>
            <div class="terminal-circle terminal-green"></div>
            <div class="terminal-title">launch_creative_strategy.py</div>
        </div>
        <div class="terminal-content">
            <pre id="code"></pre>
            <span class="cursor"></span>
        </div>
        <div class="glow"></div>
    </div>
</div>

<button id="execute-btn" class="hidden">Execute Strategy</button>

<div id="icon-display">
    <div class="icon" id="icon-1">🔍 Research & Analytics</div>
    <div class="icon" id="icon-2">🎯 Strategy & Targeting</div>
    <div class="icon" id="icon-3">🧠 AI-Powered Insights</div>
    <div class="icon" id="icon-4">💻 Creative Development</div>
</div>

<div class="loading" id="loading">
    <div class="loading-bar" id="loading-bar"></div>
    <div class="loading-glow" id="loading-glow"></div>
</div>

<div id="progress-text">Initializing resources...</div>

<div id="final-text" class="hidden">
    <p>Digital Innovation Powered by</p>
    <p>Creative Strategy & Technology</p>
</div>

<!-- <button id="enter-website" onclick="window.location.href='<?php echo home_url(); ?>'">Enter Experience</button> -->
<button id="enter-website">Enter Experience</button>
<button id="skip-button">Skip Intro →</button>