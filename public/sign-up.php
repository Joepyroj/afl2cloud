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

    const app = initializeApp(firebaseConfig);
    const auth = getAuth(app);

    document.getElementById("signup-form").addEventListener("submit", async function(e) {
      e.preventDefault();

      const email = document.getElementById("email").value.trim();
      const password = document.getElementById("password").value.trim();

      try {
        const userCredential = await createUserWithEmailAndPassword(auth, email, password);
        const user = userCredential.user;

        if (!user.emailVerified) {
          await sendEmailVerification(user);
          document.getElementById("message").textContent = "Pendaftaran berhasil. Link verifikasi telah dikirim ke email kamu.";
        } else {
          document.getElementById("message").textContent = "Email sudah terverifikasi.";
        }

        console.log("User registered:", user);
      } catch (error) {
        console.error("Error during sign up:", error);
        let msg = "Gagal mendaftar. ";
        if (error.code === 'auth/email-already-in-use') msg += "Email sudah terdaftar.";
        else if (error.code === 'auth/invalid-email') msg += "Email tidak valid.";
        else if (error.code === 'auth/weak-password') msg += "Password terlalu lemah (min 6 karakter).";
        else msg += error.message;
        document.getElementById("message").textContent = msg;
        document.getElementById("message").style.color = 'red';
      }
    });
  </script>
</body>
</html>
