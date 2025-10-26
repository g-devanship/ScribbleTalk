<?php global $user; ?>
<div class="container col-md-9 col-sm-12 rounded-0 d-flex justify-content-between">
  <div class="col-12 bg-white border rounded p-4 mt-4 shadow-sm">
    <form method="post" action="assets/php/actions.php?updateprofile" enctype="multipart/form-data">
      <div class="d-flex justify-content-center">
      <div class="d-flex justify-content-center">
  <img src="assets/images/st.jpg" alt="Profile Banner" class="img-fluid mb-3" style="border-radius: 10px; max-width: 500px; max-height: 200px;">  </div>
  </div>
      <h1 class="h5 mb-3 fw-normal text-center">Refine your Persona!</h1>

      <?php
      if (isset($_GET['success'])) {
        echo '<p class="text-success text-center">Level up! <br>Your profile just got a fresh coat of awesome.</p>';
      }
      ?>

      <div class="row">
        <div class="col-md-6 col-sm-12">
          <img src="assets/images/profile/<?= $user['profile_pic'] ?>" class="img-thumbnail my-3 rounded-circle" style="height: 150px; width: 150px;" alt="Profile Picture">

          <div class="mb-3">
            <label for="formFile" class="form-label">Switch out your Digital Disguise.</label>
            <input class="form-control" type="file" name="profile_pic" id="formFile">
          </div>
          <?= showError('profile_pic') ?>
        </div>

        <div class="col-md-6 col-sm-12">
          <div class="form-floating mt-1">
            <input type="text" name="first_name" value="<?= $user['first_name'] ?>" class="form-control rounded-0" placeholder="Frontrunner Name">
            <label for="floatingInput">Frontrunner Name :</label>
          </div>
          <?= showError('first_name') ?>

          <div class="form-floating mt-1">
            <input type="text" name="last_name" value="<?= $user['last_name'] ?>" class="form-control rounded-0" placeholder="Backrunner Name">
            <label for="floatingInput">Backrunner Name :</label>
          </div>
          <?= showError('last_name') ?>

          <div class="d-flex gap-3 my-3">
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" <?= $user['gender'] == 1 ? 'checked' : '' ?> disabled>
              <label class="form-check-label" for="exampleRadios1">Male</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios3" value="option2" <?= $user['gender'] == 2 ? 'checked' : '' ?> disabled>
              <label class="form-check-label" for="exampleRadios3">Female</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2" <?= $user['gender'] == 0 ? 'checked' : '' ?> disabled>
              <label class="form-check-label" for="exampleRadios2">Other</label>
            </div>
          </div>

          <div class="form-floating mt-1">
            <input type="email" value="<?= $user['email'] ?>" class="form-control rounded-0" placeholder="Email" disabled>
            <label for="floatingInput">Digital Mailbox :</label>
          </div>

          <div class="form-floating mt-1">
            <input type="text" value="<?= $user['username'] ?>" name="username" class="form-control rounded-0" placeholder="username/email">
            <label for="floatingInput">Avatar ID  :</label>
            </div>
            
            
            <div class="form-floating mt-1">
                    <input type="password" name="password" class="form-control rounded-0" id="floatingPassword" placeholder="Password">
              
            
            <label for="floatingPassword">Upgrade your Gatekeeper :</label>
                </div>

                <div class="mt-3 d-flex justify-content-between align-items-center">
                    <button class="btn btn-primary" type="submit">Level up my Profile-Game</button>



                </div>

            </form>
        </div>

    </div>
