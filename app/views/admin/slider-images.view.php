<?php $this->view('admin/admin-header', $data) ?>


<div class="pagetitle">
  <h1>Slider images</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.html">Home</a></li>
      <li class="breadcrumb-item">Admin</li>
      <li class="breadcrumb-item active">Slider images</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section profile">
  <div class="row">


    <div class="col-xl-12">

      <div class="card">
        <div class="card-body pt-3">
          <!-- Bordered Tabs -->
          <ul class="nav nav-tabs nav-tabs-bordered">

            <li class="nav-item">
              <button onclick="set_tab(this.getAttribute('data-bs-target'))" class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview" id="profile-overview-tab">Slider 1</button>
            </li>

            <li class="nav-item">
              <button onclick="set_tab(this.getAttribute('data-bs-target'))" class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit" id="profile-edit-tab">Slider 2</button>
            </li>

            <li class="nav-item">
              <button onclick="set_tab(this.getAttribute('data-bs-target'))" class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings" id="profile-settings-tab">Slider 3</button>
            </li>

            <li class="nav-item">
              <button onclick="set_tab(this.getAttribute('data-bs-target'))" class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password" id="profile-change-password-tab">Slider 4</button>
            </li>

          </ul>


          <div class="tab-content pt-2">

            <div class="tab-pane fade show active profile-overview" id="profile-overview">

              <form method="post" enctype="multipart/form-data">

                <div class="row mb-3">
                  <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Slider Image</label>
                  <div class="col-md-8 col-lg-9">

                    <div class="">
                      <img class="js-image-preview" src="<?= get_image($rows[1]->image ?? '') ?>" alt="Profile" style="min-width:100%;height:300px;object-fit: cover;">
                      <div class="js-filename m-2">Selected File: None</div>
                    </div>
                    <div class="pt-2">
                      <label class="btn btn-primary btn-sm" title="Upload new profile image">
                        <i class="text-white bi bi-upload"></i>
                        <input class="js-profile-image-input" onchange="load_image(event,this.files[0])" type="file" name="image" style="display: none;">
                      </label>

                      <?php if (!empty($errors['image'])) : ?>
                        <small class="js-error-image text-danger"><?= $errors['image'] ?></small>
                      <?php endif; ?>
                      <small class="js-error-image text-danger"></small>
                      <!--<a href="#" class="btn btn-danger btn-sm" title="Remove my profile image"><i class="bi bi-trash"></i></a>-->
                    </div>
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="title" class="col-md-4 col-lg-3 col-form-label">Slider title</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="title" type="text" class="form-control" id="title" value="<?= set_value('title', $rows[1]->title ?? '') ?>" required>
                  </div>

                  <?php if (!empty($errors['title'])) : ?>
                    <small class="js-error-title text-danger"><?= $errors['title'] ?></small>
                  <?php endif; ?>
                  <small class="js-error-title text-danger"></small>
                </div>

                <div class="row mb-3">
                  <label for="description" class="col-md-4 col-lg-3 col-form-label">Slider description</label>
                  <div class="col-md-8 col-lg-9">
                    <textarea name="description" class="form-control" id="description" style="height: 100px"><?= set_value('description', $rows[1]->description ?? '') ?></textarea>
                  </div>
                </div>

                <?php if (!empty($errors['description'])) : ?>
                  <small class="js-error-description text-danger"><?= $errors['description'] ?></small>
                <?php endif; ?>
                <small class="js-error-description text-danger"></small>

                <div class="js-prog progress my-4 hide">
                  <div class="progress-bar" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">Saving.. 50%</div>
                </div>

                <div class="text-center">
                  <a href="<?= ROOT ?>/admin">
                    <button type="button" class="btn btn-primary  float-start">Back</button>
                  </a>
                  <button type="button" onclick="save_image(event,1)" type="submit" class="btn btn-danger float-end">Save Changes</button>
                </div>

              </form><!-- End Profile Edit Form -->

            </div>

            <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

              <form method="post" enctype="multipart/form-data">

                <div class="row mb-3">
                  <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Slider Image</label>
                  <div class="col-md-8 col-lg-9">

                    <div class="">
                      <img class="js-image-preview" src="<?= get_image($rows[2]->image ?? '') ?>" alt="Profile" style="min-width:100%;height:300px;object-fit: cover;">
                      <div class="js-filename m-2">Selected File: None</div>
                    </div>
                    <div class="pt-2">
                      <label class="btn btn-primary btn-sm" title="Upload new profile image">
                        <i class="text-white bi bi-upload"></i>
                        <input class="js-profile-image-input" onchange="load_image(event,this.files[0])" type="file" name="image" style="display: none;">
                      </label>

                      <?php if (!empty($errors['image'])) : ?>
                        <small class="js-error-image text-danger"><?= $errors['image'] ?></small>
                      <?php endif; ?>
                      <small class="js-error-image text-danger"></small>
                      <!--<a href="#" class="btn btn-danger btn-sm" title="Remove my profile image"><i class="bi bi-trash"></i></a>-->
                    </div>
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="title" class="col-md-4 col-lg-3 col-form-label">Slider title</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="title" type="text" class="form-control" id="title" value="<?= set_value('title', $rows[2]->title ?? '') ?>" required>
                  </div>

                  <?php if (!empty($errors['title'])) : ?>
                    <small class="js-error-title text-danger"><?= $errors['title'] ?></small>
                  <?php endif; ?>
                  <small class="js-error-title text-danger"></small>
                </div>

                <div class="row mb-3">
                  <label for="description" class="col-md-4 col-lg-3 col-form-label">Slider description</label>
                  <div class="col-md-8 col-lg-9">
                    <textarea name="description" class="form-control" id="description" style="height: 100px"><?= set_value('description', $rows[2]->description ?? '') ?></textarea>
                  </div>
                </div>

                <?php if (!empty($errors['description'])) : ?>
                  <small class="js-error-description text-danger"><?= $errors['description'] ?></small>
                <?php endif; ?>
                <small class="js-error-description text-danger"></small>

                <div class="js-prog progress my-4 hide">
                  <div class="progress-bar" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">Saving.. 50%</div>
                </div>

                <div class="text-center">
                  <a href="<?= ROOT ?>/admin">
                    <button type="button" class="btn btn-primary  float-start">Back</button>
                  </a>
                  <button type="button" onclick="save_image(event,2)" type="submit" class="btn btn-danger float-end">Save Changes</button>
                </div>

              </form><!-- End Profile Edit Form -->

            </div>

            <div class="tab-pane fade pt-3" id="profile-settings">

              <form method="post" enctype="multipart/form-data">

                <div class="row mb-3">
                  <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Slider Image</label>
                  <div class="col-md-8 col-lg-9">

                    <div class="">
                      <img class="js-image-preview" src="<?= get_image($rows[3]->image ?? '') ?>" alt="Profile" style="min-width:100%;height:300px;object-fit: cover;">
                      <div class="js-filename m-2">Selected File: None</div>
                    </div>
                    <div class="pt-2">
                      <label class="btn btn-primary btn-sm" title="Upload new profile image">
                        <i class="text-white bi bi-upload"></i>
                        <input class="js-profile-image-input" onchange="load_image(event,this.files[0])" type="file" name="image" style="display: none;">
                      </label>

                      <?php if (!empty($errors['image'])) : ?>
                        <small class="js-error-image text-danger"><?= $errors['image'] ?></small>
                      <?php endif; ?>
                      <small class="js-error-image text-danger"></small>
                      <!--<a href="#" class="btn btn-danger btn-sm" title="Remove my profile image"><i class="bi bi-trash"></i></a>-->
                    </div>
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="title" class="col-md-4 col-lg-3 col-form-label">Slider title</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="title" type="text" class="form-control" id="title" value="<?= set_value('title', $rows[3]->title ?? '') ?>" required>
                  </div>

                  <?php if (!empty($errors['title'])) : ?>
                    <small class="js-error-title text-danger"><?= $errors['title'] ?></small>
                  <?php endif; ?>
                  <small class="js-error-title text-danger"></small>
                </div>

                <div class="row mb-3">
                  <label for="description" class="col-md-4 col-lg-3 col-form-label">Slider description</label>
                  <div class="col-md-8 col-lg-9">
                    <textarea name="description" class="form-control" id="description" style="height: 100px"><?= set_value('description', $rows[3]->description ?? '') ?></textarea>
                  </div>
                </div>

                <?php if (!empty($errors['description'])) : ?>
                  <small class="js-error-description text-danger"><?= $errors['description'] ?></small>
                <?php endif; ?>
                <small class="js-error-description text-danger"></small>

                <div class="js-prog progress my-4 hide">
                  <div class="progress-bar" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">Saving.. 50%</div>
                </div>

                <div class="text-center">
                  <a href="<?= ROOT ?>/admin">
                    <button type="button" class="btn btn-primary  float-start">Back</button>
                  </a>
                  <button type="button" onclick="save_image(event,3)" type="submit" class="btn btn-danger float-end">Save Changes</button>
                </div>

              </form><!-- End Profile Edit Form -->

            </div>

            <div class="tab-pane fade pt-3" id="profile-change-password">

              <form method="post" enctype="multipart/form-data">

                <div class="row mb-3">
                  <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Slider Image</label>
                  <div class="col-md-8 col-lg-9">

                    <div class="">
                      <img class="js-image-preview" src="<?= get_image($rows[4]->image ?? '') ?>" alt="Profile" style="min-width:100%;height:300px;object-fit: cover;">
                      <div class="js-filename m-2">Selected File: None</div>
                    </div>
                    <div class="pt-2">
                      <label class="btn btn-primary btn-sm" title="Upload new profile image">
                        <i class="text-white bi bi-upload"></i>
                        <input class="js-profile-image-input" onchange="load_image(event,this.files[0])" type="file" name="image" style="display: none;">
                      </label>

                      <?php if (!empty($errors['image'])) : ?>
                        <small class="js-error-image text-danger"><?= $errors['image'] ?></small>
                      <?php endif; ?>
                      <small class="js-error-image text-danger"></small>
                      <!--<a href="#" class="btn btn-danger btn-sm" title="Remove my profile image"><i class="bi bi-trash"></i></a>-->
                    </div>
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="title" class="col-md-4 col-lg-3 col-form-label">Slider title</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="title" type="text" class="form-control" id="title" value="<?= set_value('title', $rows[4]->title ?? '') ?>" required>
                  </div>

                  <?php if (!empty($errors['title'])) : ?>
                    <small class="js-error-title text-danger"><?= $errors['title'] ?></small>
                  <?php endif; ?>
                  <small class="js-error-title text-danger"></small>
                </div>

                <div class="row mb-3">
                  <label for="description" class="col-md-4 col-lg-3 col-form-label">Slider description</label>
                  <div class="col-md-8 col-lg-9">
                    <textarea name="description" class="form-control" id="description" style="height: 100px"><?= set_value('description', $rows[4]->description ?? '') ?></textarea>
                  </div>
                </div>

                <?php if (!empty($errors['description'])) : ?>
                  <small class="js-error-description text-danger"><?= $errors['description'] ?></small>
                <?php endif; ?>
                <small class="js-error-description text-danger"></small>

                <div class="js-prog progress my-4 hide">
                  <div class="progress-bar" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">Saving.. 50%</div>
                </div>

                <div class="text-center">
                  <a href="<?= ROOT ?>/admin">
                    <button type="button" class="btn btn-primary  float-start">Back</button>
                  </a>
                  <button type="button" onclick="save_image(event,4)" type="submit" class="btn btn-danger float-end">Save Changes</button>
                </div>

              </form><!-- End Profile Edit Form -->
            </div>

          </div><!-- End Bordered Tabs -->

        </div>
      </div>

    </div>
  </div>
</section>


<script>
  var tab = sessionStorage.getItem("tab") ? sessionStorage.getItem("tab") : "#profile-overview";
  var uploading = false;

  function show_tab(tab_name) {
    const someTabTriggerEl = document.querySelector(tab_name + "-tab");
    const tab = new bootstrap.Tab(someTabTriggerEl);

    tab.show();

  }

  function set_tab(tab_name) {
    tab = tab_name;
    sessionStorage.setItem("tab", tab_name);
  }

  function load_image(e, file) {

    var form = e.currentTarget.form;
    form.querySelector(".js-filename").innerHTML = "Selected File: " + file.name;

    var mylink = window.URL.createObjectURL(file);
    form.querySelector(".js-image-preview").src = mylink;
  }

  window.onload = function() {

    show_tab(tab);
  }

  //upload functions
  function save_image(e, id) {

    if (uploading) {
      alert("please wait for the other image to complete uploading");
      return;
    }

    uploading = true;

    var form = e.currentTarget.form;
    var inputs = form.querySelectorAll("input,textarea");
    var obj = {};
    var image_added = false;

    for (var i = 0; i < inputs.length; i++) {
      var key = inputs[i].name;

      if (key == 'image') {
        if (typeof inputs[i].files[0] == 'object') {
          obj[key] = inputs[i].files[0];
          image_added = true;
        }
      } else {
        obj[key] = inputs[i].value;
      }
    }

    //add form id
    obj.id = id;

    //validate image
    if (image_added) {

      var allowed = ['jpg', 'jpeg', 'png'];
      if (typeof obj.image == 'object') {
        var ext = obj.image.name.split(".").pop();
      }

      if (!allowed.includes(ext.toLowerCase())) {
        alert("Only these file types are allowed in profile image: " + allowed.toString(","));
        return;
      }
    } else {
      alert("an image is required");
      return;
    }

    //validate
    if (obj.title == "") {
      alert("a title is required");
      return;
    }

    if (obj.description == "") {
      alert("a description is required");
      return;
    }


    send_data(obj);

  }

  function send_data(obj, progbar = 'js-prog') {

    var prog = document.querySelector("." + progbar);
    prog.children[0].style.width = "0%";
    prog.classList.remove("hide");

    var myform = new FormData();
    for (key in obj) {
      myform.append(key, obj[key]);
    }

    var ajax = new XMLHttpRequest();

    ajax.addEventListener('readystatechange', function() {

      if (ajax.readyState == 4) {

        if (ajax.status == 200) {
          //everything went well
          //alert("upload complete");
          uploading = false;
          handle_result(ajax.responseText);
        } else {
          //error
          alert("an error occurred");
        }
      }
    });

    ajax.upload.addEventListener('progress', function(e) {

      var percent = Math.round((e.loaded / e.total) * 100);
      prog.children[0].style.width = percent + "%";
      prog.children[0].innerHTML = "Saving.. " + percent + "%";

    });

    ajax.open('post', '', true);
    ajax.send(myform);

  }

  function handle_result(result) {

    console.log(result);
    var obj = JSON.parse(result);
    if (typeof obj == 'object') {
      //object was created

      if (typeof obj.errors == 'object') {
        //we have errors
        display_errors(obj.errors);
        alert("Please correct the errors on the page");
      } else {
        //save complete
        alert(obj.message);
        window.location.reload();

      }
    }
  }

  function display_errors(errors) {

    for (key in errors) {

      document.querySelector(".js-error-" + key).innerHTML = errors[key];
    }
  }
</script>

<?php $this->view('admin/admin-footer', $data) ?>