<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sign Up</title>
</head>
<body>
  <h2>Sign Up Form</h2>
  <form id="signup-form">
    <input type="email" id="email" placeholder="Email" required />
    <input type="password" id="password" placeholder="Password" required />
    <button type="submit">Sign Up</button>
  </form>

  <div id="message" style="text-align:center; margin-top:10px;"></div>

  <script src="https://www.gstatic.com/firebasejs/10.8.1/firebase-app-compat.js"></script>
  <script src="https://www.gstatic.com/firebasejs/10.8.1/firebase-auth-compat.js"></script>

  <script>
    // Konfigurasi Firebase (samakan dengan login.php)
    const firebaseConfig = {
      apiKey: "AIzaSyB9vxxx_xxx_your_key_here",
      authDomain: "aflcloudjulius.firebaseapp.com",
      projectId: "aflcloudjulius",
      storageBucket: "aflcloudjulius.appspot.com",
      messagingSenderId: "123456789012",
      appId: "1:123456789012:web:abcdefgh123456"
    };

    // Inisialisasi Firebase
    const app = firebase.initializeApp(firebaseConfig);
    const auth = firebase.auth();

    document.getElementById("signup-form").addEventListener("submit", function(e) {
      e.preventDefault();

      const email = document.getElementById("email").value.trim();
      const password = document.getElementById("password").value.trim();
      const messageDiv = document.getElementById("message");

      auth.createUserWithEmailAndPassword(email, password)
        .then((userCredential) => {
          const user = userCredential.user;
          user.sendEmailVerification()
            .then(() => {
              messageDiv.style.color = "green";
              messageDiv.innerText = "Pendaftaran berhasil. Link verifikasi sudah dikirim ke email kamu.";
              auth.signOut(); // Logout supaya user tidak bisa login sebelum verifikasi
            })
            .catch((error) => {
              messageDiv.style.color = "red";
              messageDiv.innerText = "Gagal mengirim verifikasi email: " + error.message;
            });
        })
        .catch((error) => {
          messageDiv.style.color = "red";
