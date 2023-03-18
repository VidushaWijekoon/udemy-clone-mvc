<?php $this->view('admin/admin-header', $data) ?>

<style>
  .tabs-holder {
    display: flex;
    margin-top: 10px;
    margin-bottom: 10px;
    justify-content: center;
    text-align: center;
    flex-wrap: wrap;
  }

  .my-tab {
    flex: 1;
    border-bottom: solid 2px #ccc;
    padding-top: 10px;
    padding-bottom: 10px;
    cursor: pointer;
    user-select: none;
    min-width: 150px;

  }

  .my-tab:hover {
    color: #4154f1;
  }

  .active-tab {
    color: #4154f1;
    border-bottom: solid 2px #4154f1;
  }

  .hide {
    display: none;
  }

  .loader {
    position: relative;
    width: 200px;
    height: 200px;
    left: 50%;
    top: 50%;
    transform: translateX(-50%);
    opacity: 0.5;
  }
</style>
<?php if ($action == 'add') : ?>

  <div class="card col-md-5 mx-auto">
    <div class="card-body">
      <h5 class="card-title">New role</h5>

      <?php if (user_can('add_roles')) : ?>

        <!-- No Labels Form -->
        <form method="post" class="row g-3">

          <div class="col-md-12">
            <input value="<?= set_value('role') ?>" name="role" type="text" class="form-control <?= !empty($errors['role']) ? 'border-danger' : ''; ?>" placeholder="Role name">

            <?php if (!empty($errors['role'])) : ?>
              <small class="text-danger"><?= $errors['role'] ?></small>
            <?php endif; ?>

          </div>

          <div class="col-md-12">
            <label>Active:</label>
            <select name="disabled" class="form-select">

              <option value="0" selected="">Yes</option>
              <option value="1">No</option>

            </select>

          </div>

          <div class="text-center">
            <button type="submit" class="btn btn-primary">Save</button>

            <a href="<?= ROOT ?>/admin/roles">
              <button type="button" class="btn btn-secondary">Cancel</button>
            </a>
          </div>
        </form><!-- End No Labels Form -->
      <?php else : ?>
        <div class="alert alert-danger text-center">You dont have role to perform this action!</div>
        <a href="<?= ROOT ?>/admin/roles">
          <button type="button" class="btn btn-secondary">Back</button>
        </a>
      <?php endif; ?>

    </div>
  </div>

<?php elseif ($action == 'delete') : ?>

  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Delete role</h5>

      <?php if (!empty($row)) : ?>

        <?php if (user_can('delete_roles')) : ?>

          <div class="alert alert-danger text-center">Are you sue you want to delete this record?!</div>

          <!-- No Labels Form -->
          <form method="post" class="row g-3">

            <div class="col-md-12">
              <div class="form-control"><?= set_value('role', $row->role) ?></div>
              <?php if (!empty($errors['role'])) : ?>
                <small class="text-danger"><?= $errors['role'] ?></small>
              <?php endif; ?>

            </div>

            <div class="col-md-12">
              <div class="form-control">Active: <?= set_value('disabled', $row->disabled ? 'No' : 'Yes') ?></div>

            </div>

            <div class="text-center">
              <button type="submit" class="btn btn-danger">Delete</button>

              <a href="<?= ROOT ?>/admin/roles">
                <button type="button" class="btn btn-secondary">Cancel</button>
              </a>
            </div>
          </form><!-- End No Labels Form -->

        <?php else : ?>
          <div class="alert alert-danger text-center">You dont have role to perform this action!</div>
          <a href="<?= ROOT ?>/admin/roles">
            <button type="button" class="btn btn-secondary">Back</button>
          </a>
        <?php endif; ?>

      <?php else : ?>
        <div>That course was not found!</div>
      <?php endif; ?>

    </div>
  </div>

<?php elseif ($action == 'edit') : ?>

  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Edit role</h5>

      <?php if (!empty($row)) : ?>

        <?php if (user_can('edit_roles')) : ?>

          <!-- No Labels Form -->
          <form method="post" class="row g-3">

            <div class="col-md-12">
              <input value="<?= set_value('role', $row->role) ?>" name="role" type="text" class="form-control <?= !empty($errors['role']) ? 'border-danger' : ''; ?>" placeholder="Role name">

              <?php if (!empty($errors['role'])) : ?>
                <small class="text-danger"><?= $errors['role'] ?></small>
              <?php endif; ?>

            </div>

            <div class="col-md-12">
              <select name="disabled" class="form-select">

                <option <?= set_select('disabled', '0', $row->disabled) ?> value="0" selected="">Yes</option>
                <option <?= set_select('disabled', '1', $row->disabled) ?> value="1">No</option>

              </select>

            </div>

            <div class="text-center">
              <button type="submit" class="btn btn-primary">Save</button>

              <a href="<?= ROOT ?>/admin/roles">
                <button type="button" class="btn btn-secondary">Cancel</button>
              </a>
            </div>
          </form><!-- End No Labels Form -->

        <?php else : ?>
          <div class="alert alert-danger text-center">You dont have role to perform this action!</div>
          <a href="<?= ROOT ?>/admin/roles">
            <button type="button" class="btn btn-secondary">Back</button>
          </a>
        <?php endif; ?>

      <?php else : ?>
        <div>That course was not found!</div>
      <?php endif; ?>

    </div>
  </div>

<?php else : ?>

  <div class="card">

    <div class="card-body">
      <h5 class="card-title">
        Roles

        <a href="<?= ROOT ?>/admin/roles/add">
          <button type="button" class="btn btn-primary float-end"><i class="bi bi-camera-video-fill"></i> New role</button>
        </a>
      </h5>

      <?php if (user_can('view_roles')) : ?>

        <!-- Table with stripped rows -->
        <form method="post">
          <button class="btn btn-primary"><i class="bi bi-harddrive"></i> Save permissions</button>
          <br>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Role</th>
                  <th scope="col">Active</th>
                  <th scope="col" style="width:600px">Permissions</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>

              <?php if (!empty($rows)) : ?>
                <tbody>

                  <?php foreach ($rows as $row) : ?>
                    <tr>
                      <th scope="row"><?= $row->id ?></th>
                      <td><?= esc($row->role) ?></td>
                      <td><?= esc($row->disabled ? 'No' : 'Yes') ?></td>
                      <td>
                        <div class="row">
                          <?php $num = 0; ?>
                          <?php foreach (PERMISSIONS as $permission) : ?>
                            <?php
                            $num++;
                            $row->permissions = $row->permissions ?? [];
                            ?>

                            <?php if (strtolower($row->role) == 'admin') : ?>
                              <div class="col-md-4 form-check form-switch">
                                <input disabled checked class="form-check-input" type="checkbox" id="<?= $row->id ?><?= $num ?>CheckChecked">
                                <label class="form-check-label" for="<?= $row->id ?><?= $num ?>CheckChecked">all permissions</label>
                              </div>
                              <?php break; ?>
                            <?php endif; ?>

                            <div class="col-md-4 form-check form-switch">
                              <input <?= in_array($permission, $row->permissions) ? 'checked' : '' ?> name="<?= $row->id ?>_<?= $num ?>" value="<?= $permission ?>" class="form-check-input" type="checkbox" id="<?= $row->id ?><?= $num ?>CheckChecked">
                              <label class="form-check-label" for="<?= $row->id ?><?= $num ?>CheckChecked"><?= str_replace("_", " ", $permission) ?></label>
                            </div>
                          <?php endforeach; ?>
                        </div>
                      </td>
                      <td>
                        <a href="<?= ROOT ?>/admin/roles/edit/<?= $row->id ?>">
                          <i class="bi bi-pencil-square"></i>
                        </a>
                        <a href="<?= ROOT ?>/admin/roles/delete/<?= $row->id ?>">
                          <i class="bi bi-trash-fill text-danger"></i>
                        </a>
                      </td>
                    </tr>
                  <?php endforeach; ?>

                </tbody>
              <?php else : ?>
                <tr>
                  <td colspan="10">No records found!</td>
                </tr>
              <?php endif; ?>

            </table>
          </div>
        </form>
        <!-- End Table with stripped rows -->
      <?php else : ?>
        <div class="alert alert-danger text-center">You dont have role to perform this action!</div>
      <?php endif; ?>

    </div>
  </div>

<?php endif; ?>


<?php $this->view('admin/admin-footer', $data) ?>