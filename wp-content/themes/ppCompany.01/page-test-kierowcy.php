<?php
/**
 * Template Name: Test Kierowcy
 */

get_header(); ?>

<h1>TEST SYSTEMU KIEROWCÓW</h1>
<p>Jeśli to widzisz - template działa!</p>

<div style="background: lightblue; padding: 20px; margin: 20px;">
    <h2>🚗 Podstawowy test logowania</h2>
    
    <div id="loginTest">
        <label>Użytkownik: <input type="text" id="user" value="admin"></label><br><br>
        <label>Hasło: <input type="password" id="pass" value="admin123"></label><br><br>
        <button onclick="testLogin()">Zaloguj</button>
    </div>
    
    <div id="result" style="margin-top: 20px;"></div>
</div>

<script>
function testLogin() {
    const user = document.getElementById('user').value;
    const pass = document.getElementById('pass').value;
    const result = document.getElementById('result');
    
    if (user === 'admin' && pass === 'admin123') {
        result.innerHTML = '<h3 style="color: green;">✅ LOGOWANIE DZIAŁA!</h3>';
        
        // Pokaż podstawową tabelę
        result.innerHTML += `
            <table border="1" style="margin-top: 20px; border-collapse: collapse;">
                <tr style="background: #333; color: white;">
                    <th>KIEROWCA</th>
                    <th>PONIEDZIAŁEK</th>
                    <th>WTOREK</th>
                    <th>ŚRODA</th>
                </tr>
                <tr>
                    <td>Kierowca 1</td>
                    <td><input type="time"> - <input type="time"></td>
                    <td><input type="time"> - <input type="time"></td>
                    <td><input type="time"> - <input type="time"></td>
                </tr>
                <tr>
                    <td>Kierowca 2</td>
                    <td><input type="time"> - <input type="time"></td>
                    <td><input type="time"> - <input type="time"></td>
                    <td><input type="time"> - <input type="time"></td>
                </tr>
            </table>
            <p>🎉 <strong>Podstawowa funkcjonalność działa!</strong></p>
        `;
    } else {
        result.innerHTML = '<h3 style="color: red;">❌ Błędne dane logowania</h3>';
    }
}

// Auto-test po załadowaniu
window.onload = function() {
    console.log('JavaScript działa!');
}
</script>

<?php get_footer(); ?>