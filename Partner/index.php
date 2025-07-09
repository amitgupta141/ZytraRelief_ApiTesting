<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Provider Registration</title>
  <style>
    :root {
      --primary-color-light: cornflowerblue;
      --background-light: white;
      --text-light: grey;

      --primary-color-dark: limegreen;
      --background-dark: #000;
      --text-dark: grey;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      background-color: var(--background-light);
      color: var(--text-light);
      transition: 0.3s ease;
    }

    html[data-theme="dark"] body {
      background-color: var(--background-dark);
      color: var(--text-dark);
    }

    .container {
      width: 100vw;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 2rem;
    }

    .theme-toggle {
      align-self: flex-end;
      margin-bottom: 1rem;
      padding: 0.5rem 1rem;
      border: none;
      background-color: var(--primary-color-light);
      color: white;
      border-radius: 5px;
      cursor: pointer;
    }

    html[data-theme="dark"] .theme-toggle {
      background-color: var(--primary-color-dark);
    }

    .logo {
      font-size: 24px;
      margin-bottom: 1rem;
      color: var(--text-light);
    }

    html[data-theme="dark"] .logo {
      color: var(--text-dark);
    }

    .welcome {
      font-size: 32px;
      margin-bottom: 0.5rem;
    }

    .headline {
      font-size: 16px;
      margin-bottom: 1.5rem;
    }

    form {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1rem 2rem;
      width: 100%;
      max-width: 800px;
      margin-bottom: 2rem;
    }

    label {
      grid-column: span 1;
      font-size: 16px;
    }

    input[type="text"],
    input[type="email"],
    input[type="number"],
    input[type="password"],
    textarea {
      padding: 10px;
      font-size: 16px;
      border: none;
      border-radius: 10px;
      outline: none;
      box-shadow: inset 2px 2px 5px grey, inset -2px -2px 5px white;
      transition: 0.3s ease;
    }

    textarea {
      grid-column: span 2;
      resize: none;
    }

    html[data-theme="dark"] input,
    html[data-theme="dark"] textarea {
      box-shadow: 0 0 8px var(--primary-color-dark);
      background-color: #111;
      color: var(--text-dark);
    }

    input[type="submit"] {
      grid-column: span 2;
      padding: 12px;
      font-size: 16px;
      text-transform: uppercase;
      border: none;
      border-radius: 10px;
      background-color: var(--primary-color-light);
      color: white;
      cursor: pointer;
      margin-top: 1rem;
    }

    html[data-theme="dark"] input[type="submit"] {
      background-color: var(--primary-color-dark);
    }

    .footer {
      display: flex;
      justify-content: space-between;
      width: 100%;
      max-width: 800px;
      font-size: 14px;
      color: var(--text-light);
    }

    html[data-theme="dark"] .footer {
      color: var(--text-dark);
    }

    @media (max-width: 768px) {
      form {
        grid-template-columns: 1fr;
      }

      input[type="submit"] {
        grid-column: span 1;
      }

      .footer {
        flex-direction: column;
        gap: 10px;
        align-items: center;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <button class="theme-toggle" onclick="toggleTheme()">Toggle Theme</button>
    <h1 class="logo">LOGO</h1>
    <h2 class="welcome">Welcome Back</h2>
    <p class="headline">Enter your email and password to access your account</p>

    <form action="./save_provider.php" method="post">
      <label for="providerName">Name</label>
      <input type="text" placeholder="Enter Name" class="providerName" id="providerName" name="providerName">

      <label for="providerEmail">Email</label>
      <input type="email" placeholder="Enter Email" class="providerEmail" id="providerEmail" name="providerEmail">

      <label for="providerPhone">Phone</label>
      <input type="number" placeholder="Enter Number" class="providerPhone" id="providerPhone" name="providerPhone">

      <label for="providerPassword">Password</label>
      <input type="password" placeholder="Set Up Password" class="providerPassword" id="providerPassword" name="providerPassword">

      <label for="providerCategory">Profession</label>
      <input type="text" placeholder="Enter Category" class="providerCategory" id="providerCategory" name="providerCategory">

      <label for="providerAddress">Address</label>
      <textarea cols="55" rows="3" class="providerAddress" id="providerAddress" name="providerAddress">Enter Address..</textarea>

      <input type="submit" value="Unlock">
    </form>

    <div class="footer">
      <p class="copyright">© 2025 ABC Enterprises LTD.</p>
      <p class="privacy-policy">Privacy Policy</p>
    </div>
  </div>

  <script>
    function toggleTheme() {
      const root = document.documentElement;
      const current = root.getAttribute("data-theme");
      root.setAttribute("data-theme", current === "light" ? "dark" : "light");
    }
  </script>
</body>
</html>
