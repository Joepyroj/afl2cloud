<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <!-- Firebase SDK -->
  <script src="https://www.gstatic.com/firebasejs/9.6.11/firebase-app.js"></script>
  <script src="https://www.gstatic.com/firebasejs/9.6.11/firebase-auth.js"></script>

  <style>
    body { font-family: Arial, sans-serif; }
    form { max-width: 300px; margin: auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px; }
    input, button { width: 100%; margin-bottom: 10px; padding: 8px; }
  </style>
</head>
<body>

<h2 style="text-align:center;">Login</h2>
<form id="login-form">
  <input type="email" id="email" placeholder="Email" required />
  <input type="password" id="password" placeholder="Password" required />
  <button type="submit">Login</button>
</form>

<div id="message" style="text-align:center; margin-top: 10px;"></div>

<script>
  // ✅ Konfigurasi Firebase kamu
  const firebaseConfig = {
    apiKey: "AIzaSyBvoxxRo2UC0XCKmuyMrRE3jjVFlboMeKs",
    authDomain: "aflcloudjulius.firebaseapp.com",
    projectId: "aflcloudjulius",
    storageBucket: "aflcloudjulius.firebasestorage.app",
    messagingSenderId: "1034706840573",
    appId: "1:1034706840573:web:df4b46440718fe0903c794",
  };

  // Inisialisasi Firebase
  const app = firebase.initializeApp(firebaseConfig);
  const auth = firebase.auth();

  // Tangani login form
  document.getElementById("login-form").addEventListener("submit", function(e) {
    e.preventDefault();
    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value.trim();

    auth.signInWithEmailAndPassword(email, password)
      .then((userCredential) => {
        const user = userCredential.user;
        if (user.emailVerified) {
          document.getElementById("message").innerText = "Login berhasil! Email sudah diverifikasi.";
          // Lanjut ke halaman form.php misalnya
          setTimeout(() => {
            window.location.href = "form.php";
          }, 1000);
        } else {
          // Kirim verifikasi email
          user.sendEmailVerification()
            .then(() => {
              document.getElementById("message").innerText = "Login berhasil, tapi email belum diverifikasi. Email verifikasi telah dikirim. Silakan cek inbox.";
            });
        }
      })
      .catch((error) => {
        document.getElementById("message").innerText = "Login gagal: " + error.message;
      });
  });
</script>

</body>
</html>
