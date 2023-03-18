<form>

  <?php csrf() ?>

  <div class="col-md-10 mx-auto">

    <div class="h5"><b>Curriculum</b></div>

    <div class="my-4 row mb-1 border pb-4">
      <label for="inputPassword" class="col-12 col-form-label"><b>Here’s where you add course content—like lectures, course sections, assignments, and more. <br>Click a + icon on the left to get started.</b></label>
      <small>Start putting together your course by creating sections, lectures and practice (quizzes, coding exercises and assignments).

        If you’re intending to offer your course for free, the total length of video content must be less than 2 hours</small>

      <div class="col-sm-12 js-curriculum">

      </div>
      <small class="error error-welcome_message w-100 text-danger"></small>

    </div>
    <button onclick="curriculum.add_new('js-curriculum',{placeHolder:'Enter title',name:'curriculum'})" type="button" class="btn btn-sm btn-primary js-curriculum-add">+ Add section</button>


  </div>

</form>