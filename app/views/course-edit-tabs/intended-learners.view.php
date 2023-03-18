<form>

  <?php csrf() ?>

  <div class="col-md-10 mx-auto">

    <div class="h5"><b>Intended learners</b></div>

    <div class="my-4 row mb-1 border">
      <label for="inputPassword" class="col-12 col-form-label"><b>What will students learn in your course?</b></label>
      <small>You must enter at least 4 learning objectives or outcomes that learners can expect to achieve after completing your course</small>

      <div class="col-sm-12 js-students-learn">

      </div>
      <small class="error error-welcome_message w-100 text-danger"></small>
    </div>
    <button onclick="intended_learners.add_new('js-students-learn',{placeHolder:'Example: Define the roles and responsibilities of a project manager',name:'students-learn'})" type="button" class="btn btn-sm btn-primary js-students-learn-add">+ Add more</button>

    <div class="my-4 row mb-1 border">
      <label for="inputPassword" class="col-12 col-form-label"><b>What are the requirements or prerequisites for taking your course?</b></label>
      <small>List the required skills, experience, tools or equipment learners should have prior to taking your course.
        If there are no requirements, use this space as an opportunity to lower the barrier for beginners.</small>

      <div class="col-sm-12 js-prerequisites">

      </div>
      <small class="error error-welcome_message w-100 text-danger"></small>
    </div>
    <button onclick="intended_learners.add_new('js-prerequisites',{placeHolder:'Example: No programming experience needed. You will learn everything you need to know',name:'prerequisites'})" type="button" class="btn btn-sm btn-primary js-prerequisites-add">+ Add more</button>

    <div class="my-4 row mb-1 border">
      <label for="inputPassword" class="col-12 col-form-label"><b>Who is this course for?</b></label>
      <small>Write a clear description of the intended learners for your course who will find your course content valuable.
        This will help you attract the right learners to your course.</small>

      <div class="col-sm-12 js-whose-course">

      </div>
      <small class="error error-welcome_message w-100 text-danger"></small>
    </div>
    <button onclick="intended_learners.add_new('js-whose-course',{placeHolder:'Example: Beginner Python developers curious about data science',name:'whose-course'})" type="button" class="btn btn-sm btn-primary js-whose-course-add">+ Add more</button>


  </div>

</form>