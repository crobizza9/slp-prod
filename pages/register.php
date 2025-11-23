<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SLP - Shipping Logistics Platform</title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap"
    rel="stylesheet" />

  <!-- Font Awesome -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
    integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer" />

  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
    crossorigin="anonymous" />

  <!-- Main Stylesheet -->
  <link rel="stylesheet" href="/css/style.css" />



</head>


<body class="d-flex flex-column min-vh-100 bg-dark">
  <div class="container text-light text-center d-flex flex-column justify-content-center align-items-center">
    <div class="container">
      <div class="card mt-5 slp-theme-light shadow">
        <div class="card-body">

          <div class="row">

            <div class="col">
              <img src="/img/slp-register.jpg" alt="" class="img-fluid rounded card-img">
            </div>
            <form id="registerForm" action="register-user.php" method="post" class="col p-5">
              <h2>Sign up here</h2>
              <label for="firstname" class="mb-3 form-label">First Name</label>
              <input
                type="text"
                name="firstname"
                id="firstname"
                class="form-control mb-3" />
              <label for="lastname" class="mb-3 form-label">Last Name</label>
              <input
                type="text"
                name="lastname"
                id="lastname"
                class="mb-3 form-control" />
              <label for="email" class="form-label mb-3">Email</label>
              <input type="email" name="email" id="email" class="form-control mb-3" />
              <label for="password" class="form-label mb-3">Password</label>
              <input
                type="password"
                name="password"
                id="password"
                class="form-control mb-3" />
              <label for="confirm-password" class="form-label mb-3">Confirm Password</label>
              <input
                type="password"
                name="confirm-password"
                id="confirm-password"
                class="form-control mb-3" />

              <button type="submit" class="btn btn-primary mt-3 ">Register</button>
              <p class="form-text text-dark">Already have an acccount? <a href="login.php" class="ink-offset-2 link-underline link-underline-opacity-50 mt-3">Login</a></p>
              <a href="/index.php" class="mt-auto">Home Page</a>

            </form>
          </div>
        </div>
      </div>

    </div>
  </div>




  <footer class="mt-auto slp-gradient shadow p-2">
    <div class="container text-center">
      &copy;
      <?php echo date("Y"); ?>
      Shipping Logistics Platform. All rights reserved.
    </div>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js" integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" crossorigin="anonymous"></script>
</body>

</html>