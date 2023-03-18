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
      <h5 class="card-title">New category</h5>

      <?php if (user_can('add_categories')) : ?>

        <!-- No Labels Form -->
        <form method="post" class="row g-3">

          <div class="col-md-12">
            <input value="<?= set_value('category') ?>" name="category" type="text" class="form-control <?= !empty($errors['category']) ? 'border-danger' : ''; ?>" placeholder="Category name">

            <?php if (!empty($errors['category'])) : ?>
              <small class="text-danger"><?= $errors['category'] ?></small>
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

            <a href="<?= ROOT ?>/admin/categories">
              <button type="button" class="btn btn-secondary">Cancel</button>
            </a>
          </div>
        </form><!-- End No Labels Form -->
      <?php else : ?>
        <div class="alert alert-danger text-center">You dont have permission to perform this action!</div>
        <a href="<?= ROOT ?>/admin/categories">
          <button type="button" class="btn btn-secondary">Back</button>
        </a>
      <?php endif; ?>

    </div>
  </div>

<?php elseif ($action == 'delete') : ?>

  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Delete category</h5>

      <?php if (!empty($row)) : ?>

        <?php if (user_can('delete_categories')) : ?>

          <div class="alert alert-danger text-center">Are you sue you want to delete this record?!</div>

          <!-- No Labels Form -->
          <form method="post" class="row g-3">

            <div class="col-md-12">
              <div class="form-control"><?= set_value('category', $row->category) ?></div>
              <?php if (!empty($errors['category'])) : ?>
                <small class="text-danger"><?= $errors['category'] ?></small>
              <?php endif; ?>

            </div>

            <div class="col-md-12">
              <div class="form-control">Active: <?= set_value('disabled', $row->disabled ? 'No' : 'Yes') ?></div>

            </div>

            <div class="text-center">
              <button type="submit" class="btn btn-danger">Delete</button>

              <a href="<?= ROOT ?>/admin/categories">
                <button type="button" class="btn btn-secondary">Cancel</button>
              </a>
            </div>
          </form><!-- End No Labels Form -->

        <?php else : ?>
          <div class="alert alert-danger text-center">You dont have permission to perform this action!</div>
          <a href="<?= ROOT ?>/admin/categories">
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
      <h5 class="card-title">Edit category</h5>

      <?php if (!empty($row)) : ?>

        <?php if (user_can('edit_categories')) : ?>

          <!-- No Labels Form -->
          <form method="post" class="row g-3">

            <div class="col-md-12">
              <input value="<?= set_value('category', $row->category) ?>" name="category" type="text" class="form-control <?= !empty($errors['category']) ? 'border-danger' : ''; ?>" placeholder="Category name">

              <?php if (!empty($errors['category'])) : ?>
                <small class="text-danger"><?= $errors['category'] ?></small>
              <?php endif; ?>

            </div>

            <div class="col-md-12">
              <label>Active:</label>
              <select name="disabled" class="form-select">

                <option <?= set_select('disabled', '0', $row->disabled) ?> value="0" selected="">Yes</option>
                <option <?= set_select('disabled', '1', $row->disabled) ?> value="1">No</option>

              </select>

            </div>

            <div class="text-center">
              <button type="submit" class="btn btn-primary">Save</button>

              <a href="<?= ROOT ?>/admin/categories">
                <button type="button" class="btn btn-secondary">Cancel</button>
              </a>
            </div>
          </form><!-- End No Labels Form -->

        <?php else : ?>
          <div class="alert alert-danger text-center">You dont have permission to perform this action!</div>
          <a href="<?= ROOT ?>/admin/categories">
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
        Categories
        <a href="<?= ROOT ?>/admin/categories/add">
          <button class="btn btn-primary float-end"><i class="bi bi-camera-video-fill"></i> New category</button>
        </a>
      </h5>

      <?php if (user_can('view_categories')) : ?>

        <!-- Table with stripped rows -->
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Category</th>
              <th scope="col">Active</th>
              <th scope="col">slug</th>
              <th scope="col">Action</th>
            </tr>
          </thead>

          <?php if (!empty($rows)) : ?>
            <tbody>

              <?php foreach ($rows as $row) : ?>
                <tr>
                  <th scope="row"><?= $row->id ?></th>
                  <td><?= esc($row->category) ?></td>
                  <td><?= esc($row->disabled ? 'No' : 'Yes') ?></td>
                  <td><?= esc($row->slug) ?></td>
                  <td>
                    <a href="<?= ROOT ?>/admin/categories/edit/<?= $row->id ?>">
                      <i class="bi bi-pencil-square"></i>
                    </a>
                    <a href="<?= ROOT ?>/admin/categories/delete/<?= $row->id ?>">
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
        <!-- End Table with stripped rows -->
      <?php else : ?>
        <div class="alert alert-danger text-center">You dont have permission to perform this action!</div>
      <?php endif; ?>

    </div>
  </div>

<?php endif; ?>


<?php $this->view('admin/admin-footer', $data) ?>