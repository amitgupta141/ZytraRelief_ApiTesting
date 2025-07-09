<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Registration</title>
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
      height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 2rem;
      overflow:hidden;
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
    input[type="password"] {
      padding: 10px;
      font-size: 16px;
      border: none;
      border-radius: 10px;
      outline: none;
      box-shadow: inset 2px 2px 5px grey, inset -2px -2px 5px white;
      transition: 0.3s ease;
    }

    html[data-theme="dark"] input[type="text"],
    html[data-theme="dark"] input[type="email"],
    html[data-theme="dark"] input[type="number"],
    html[data-theme="dark"] input[type="password"] {
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
    <h2 class="welcome">Register Now</h2>
    <p class="headline">Enter your details below to create an account</p>

    <form action="./save_user.php" method="post">
      <label for="userName">Name</label>
      <input type="text" placeholder="Enter Name" id="userName" name="userName">

      <label for="userEmail">Email</label>
      <input type="email" placeholder="Enter Email" id="userEmail" name="userEmail">

      <label for="userPhone">Phone</label>
      <input type="number" placeholder="With country code" id="userPhone" name="userPhone">

      <label for="userCategory">Category</label>
      <input type="text" placeholder="Enter Category" id="userCategory" name="userCategory">

      <label for="userAddress">Address</label>
      <input type="text" placeholder="Enter Address" id="userAddress" name="userAddress">

      <label for="userPassword">Password</label>
      <input type="password" placeholder="Set Password" id="userPassword" name="userPassword">

      <input type="submit" value="Get In">
    </form>

    <div class="footer">
      <p>© 2025 ABC Enterprises LTD.</p>
      <p>Privacy Policy</p>
    </div>
  </div>

  <script>
    function toggleTheme() {
      const root = document.documentElement;
      const currentTheme = root.getAttribute("data-theme");
      root.setAttribute("data-theme", currentTheme === "light" ? "dark" : "light");
    }
  </script>
  <script src="./script.js"></script>
</body>
</html>
