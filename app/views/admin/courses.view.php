<?php $this->view('admin/admin-header',$data) ?>

<style>
  
  .tabs-holder{
    display: flex;
    margin-top: 10px; 
    margin-bottom: 10px;
    justify-content: center;
    text-align: center;
    flex-wrap: wrap;
  }

  .my-tab{
    flex:1;
    border-bottom: solid 2px #ccc;
    padding-top: 10px;
    padding-bottom: 10px;
    cursor: pointer;
    user-select: none;
    min-width: 150px;

  }
  .my-tab:hover{
    color: #4154f1;
  }

  .active-tab{
    color: #4154f1;
    border-bottom: solid 2px #4154f1;
  }

  .hide{
    display: none;
  }

  .loader{
    position: relative;
    width:200px;
    height:200px;
    left: 50%;
    top: 50%;
    transform: translateX(-50%);
    opacity: 0.5;
  }

</style>
<?php if($action == 'add'):?>

  <div class="card col-md-5 mx-auto">
    <div class="card-body">
      <h5 class="card-title">New Course</h5>

      <!-- No Labels Form -->
      <form method="post" class="row g-3">
        
        <div class="col-md-12">
          <input value="<?=set_value('title')?>" name="title" type="text" class="form-control <?=!empty($errors['title']) ? 'border-danger':'';?>" placeholder="Course title">

          <?php if(!empty($errors['title'])):?>
            <small class="text-danger"><?=$errors['title']?></small>
          <?php endif;?>

        </div>

        <div class="col-md-12">
          <input value="<?=set_value('primary_subject')?>" name="primary_subject" type="text" class="form-control <?=!empty($errors['primary_subject']) ? 'border-danger':'';?>" placeholder="Primary subject e.g Photography or Vlogging">

          <?php if(!empty($errors['primary_subject'])):?>
            <small class="text-danger"><?=$errors['primary_subject']?></small>
          <?php endif;?>

        </div>
 
 
        <div class="col-md-12">
          <select name="category_id" id="inputState" class="form-select <?=!empty($errors['category_id']) ? 'border-danger':'';?>">
            
            <option value="" selected="">Course Category...</option>
            <?php if(!empty($categories)):?>
              <?php foreach($categories as $cat):?>
                <option <?=set_select('category_id',$cat->id)?> value="<?=$cat->id?>"><?=esc($cat->category)?></option>
              <?php endforeach;?>
            <?php endif;?>

          </select>

          <?php if(!empty($errors['category_id'])):?>
            <small class="text-danger"><?=$errors['category_id']?></small>
          <?php endif;?>

        </div>
    
        <div class="text-center">
          <button type="submit" class="btn btn-primary">Save</button>

          <a href="<?=ROOT?>/admin/courses">
            <button type="button" class="btn btn-secondary">Cancel</button>
          </a>
        </div>
      </form><!-- End No Labels Form -->

    </div>
  </div>

<?php elseif($action == 'delete'):?>
  
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Delete Course</h5>

      <?php if(!empty($row)):?>
        
        <div class="alert alert-danger text-center">Are you sue you want to delete this course?!</div>

        <form method="post">
          <div class="float-end">
            <button class="btn btn-danger">Delete</button>
            <a href="<?=ROOT?>/admin/courses">
              <button class="btn btn-primary">Back</button>
            </a>
          </div>
          
          <h3 class="">Course Title: <?=esc($row->title)?></h3>
          <h5 class="">Primary Subject: <?=esc($row->primary_subject)?></h5>
          <h5 class="">Category: <?=esc($row->category_row->category)?></h5>
          <h5 class="">Date created: <?=get_date($row->date)?></h5>
        </form>
      <?php else:?>
        <div>That course was not found!</div>
      <?php endif;?>

    </div>
  </div>

<?php elseif($action == 'edit'):?>

  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Edit Course</h5>

      <?php if(!empty($row)):?>

        <div class="float-end">
          <button onclick="save_content()" class="js-save-button btn btn-success disabled">Save</button>
          <a href="<?=ROOT?>/admin/courses">
            <button class="btn btn-primary">Back</button>
          </a>
        </div>
        
        <h5 class=""><?=esc($row->title)?></h5>

        <!--tabs-->
          <br>
          <div class="tabs-holder">
            <div onclick="set_tab(this.id,this)" id="intended-learners" class="my-tab active-tab">Intended Learners</div>
            <div onclick="set_tab(this.id,this)" id="curriculum" class="my-tab">Curriculum</div>
            <div onclick="set_tab(this.id,this)" id="course-landing-page" class="my-tab">Course landing page</div>
            <div onclick="set_tab(this.id,this)" id="promotions" class="my-tab">Promotions</div>
            <div onclick="set_tab(this.id,this)" id="course-messages" class="my-tab">Course messages</div>
          </div>
        <!--end tabs-->
        <!--div-tabs-->
        <div oninput="something_changed(event)" >
          <div id="tabs-content">
            
          </div>
        </div>
        <!--end div-tabs-->
 

      <?php else:?>
        <div>That course was not found!</div>
      <?php endif;?>

    </div>
  </div>

<?php else:?>

  <div class="card">

    <div class="card-body">
      <h5 class="card-title">
        My Courses 
        <a href="<?=ROOT?>/admin/courses/add">
          <button class="btn btn-primary float-end"><i class="bi bi-camera-video-fill"></i> New Course</button>
        </a>
      </h5>

      <!-- Table with stripped rows -->
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">Image</th>
            <th scope="col">Instructor</th>
            <th scope="col">Category</th>
            <th scope="col">Price</th>
            <th scope="col">Primary Subject</th>
            <th scope="col">Date</th>
            <th scope="col">Action</th>
          </tr>
        </thead>

        <?php if(!empty($rows)):?>
          <tbody>

            <?php foreach($rows as $row):?>
              <tr>
                <th scope="row"><?=$row->id?></th>
                <td><?=esc($row->title)?></td>
                <td><img src="<?=get_image($row->course_image)?>" style="width: 100px;height: 100px;object-fit: cover;"/></td>
                <td><?=esc($row->user_row->name ?? 'Unknown')?></td>
                <td><?=esc($row->category_row->category ?? 'Unknown')?></td>
                <td><?=esc($row->price_row->name ?? 'Unknown')?></td>
                <td><?=esc($row->primary_subject)?></td>
                <td><?=get_date($row->date)?></td>
                <td>
                  <a href="<?=ROOT?>/admin/courses/edit/<?=$row->id?>">
                    <i class="bi bi-pencil-square"></i> 
                  </a>
                  <a href="<?=ROOT?>/admin/courses/delete/<?=$row->id?>">
                    <i class="bi bi-trash-fill text-danger"></i>
                  </a>
                </td>
              </tr>
            <?php endforeach;?>

          </tbody>
        <?php else:?>
          <tr><td colspan="10">No records found!</td></tr>
        <?php endif;?>

      </table>
      <!-- End Table with stripped rows -->

    </div>
  </div>

<?php endif;?>

<script>
  
  var tab = sessionStorage.getItem("tab") ? sessionStorage.getItem("tab"): "intended-learners";
  var dirty = false;
  var get_meta = true;

  function show_tab(tab_name)
  {
 
    var contentDiv = document.querySelector("#tabs-content");
    show_loader(contentDiv);

    //change active tab
    var div = document.querySelector("#"+tab_name);
    var children = div.parentNode.children;
    for (var i = 0; i < children.length; i++) {
      children[i].classList.remove("active-tab");
    }

    div.classList.add("active-tab");


    send_data({
      tab_name:tab,
      data_type:"read",
    });

    disable_save_button(false);

  }

  function send_data(obj)
  {
    
    var myform = new FormData();
    for(key in obj){
      myform.append(key,obj[key]); 
    }

    var ajax = new XMLHttpRequest();

    ajax.addEventListener('readystatechange',function(){

      if(ajax.readyState == 4){

        if(ajax.status == 200){
          //everything went well
          //alert("upload complete");
          handle_result(ajax.responseText);
        }else{
          //error
          alert("an error occurred");
        }
      }
    });
 
    ajax.open('post','',true);
    ajax.send(myform);

  }


  function handle_result(result)
  {

    console.log(result);
    if(result.substr(0,2) == '{"')
    {
      var obj = JSON.parse(result);
      if(typeof obj == 'object'){

        if(obj.data_type == "save"){

          //alert(obj.data);

          //clear all errors
          var error_containers = document.querySelectorAll(".error");
          for (var i = 0; i < error_containers.length; i++) {
            error_containers[i].innerHTML = "";
          }

          //show any errors
          if(typeof obj.errors == 'object')
          {
            for(key in obj.errors)
            {
              document.querySelector(".error-"+key).innerHTML = obj.errors[key];
            }

          }else{
            disable_save_button(false);
            dirty = false;
            alert(obj.data);
          }
        }else 
        if(obj.data_type == "get-meta"){

          var obj_name = tab.replaceAll("-","_");
          window[obj_name].handle_result(obj.data);
        }

      }

    }else{

      //load tab content
      var contentDiv = document.querySelector("#tabs-content");
      contentDiv.innerHTML = result;

      //do stuff after tab is loaded
      var obj_name = tab.replaceAll("-","_");

      if(get_meta){
        get_meta = false;
        window[obj_name].get_meta(<?=$row->id?>);
      }

    }

  }

  function set_tab(tab_name)
  {

    if(dirty)
    {
      //ask user to save when switching tabs
      if(!confirm("Your changes were not saved. continue?!"))
      {
        return;
      }
    }

    get_meta = true;
    tab = tab_name;
    sessionStorage.setItem("tab", tab_name);

    dirty = false;
    show_tab(tab_name);

  }

  function something_changed(e)
  {
    dirty = tab;
    disable_save_button(true);
  }

  function disable_save_button(status = false)
  {
    if(status){
      document.querySelector(".js-save-button").classList.remove("disabled");
    }else{
      document.querySelector(".js-save-button").classList.add("disabled");
    }
  }

  function show_loader(item)
  {
    item.innerHTML = '<img class="loader" src="<?=ROOT?>/assets/images/loader.gif">';
  }

  show_tab(tab);

  /*******************
  for saving content
  ********************/

  function save_content()
  {
    var content = document.querySelector("#tabs-content");
    var inputs = content.querySelectorAll("input,textarea,select");

    var obj = {};
    obj.data_type = "save";
    obj.tab_name = tab;

    for (var i = 0; i < inputs.length; i++) {
       
      var key = inputs[i].name;
      obj[key] = inputs[i].value;

      if(inputs[i].type == 'file')
        obj[key] = inputs[i].files[0];

      if(inputs[i].getAttribute('uid'))
        obj['uid_'+key] = inputs[i].getAttribute('uid');

      /*
      if(inputs[i].getAttribute('index'))
        obj['index_'+key] = inputs[i].getAttribute('index');
      */
    }

    send_data(obj);

  }

  var course_image_uploading = false;
  var ajax_course_image = null;

  function upload_course_image(file)
  {

    if(course_image_uploading){

      alert("please wait while the other image uploads");
      return;
    }

    //validate image extension
    var allowed_types = ['jpg','jpeg','png'];
    var ext = file.name.split(".").pop();
    ext = ext.toLowerCase();

    if(!allowed_types.includes(ext))
    {
      alert("Only files of this type allowed: "+allowed_types.toString(","));
      return;
    }

    //display an image preview
    var img = document.querySelector(".js-image-upload-preview");
    var link = URL.createObjectURL(file);
    img.src = link;

    //begin upload
    course_image_uploading = true;

    document.querySelector(".js-image-upload-info").innerHTML = file.name;
    document.querySelector(".js-image-upload-info").classList.remove("hide");
    document.querySelector(".js-image-upload-input").classList.add("hide");
    document.querySelector(".js-image-upload-cancel-button").classList.remove("hide");

    var myform = new FormData();
    ajax_course_image = new XMLHttpRequest();

    ajax_course_image.addEventListener('readystatechange',function(){

      if(ajax_course_image.readyState == 4){

        if(ajax_course_image.status == 200){
          //everything went well
          //alert("upload complete");
          //alert(ajax_course_image.responseText);
        }

        course_image_uploading = false;
        document.querySelector(".js-image-upload-info").classList.add("hide");
        document.querySelector(".js-image-upload-input").classList.remove("hide");
        document.querySelector(".js-image-upload-cancel-button").classList.add("hide");

      }
    });

    ajax_course_image.addEventListener('error',function(){
      alert("an error occurred");
    });

    ajax_course_image.addEventListener('abort',function(){
      alert("upload aborted");
    });

    ajax_course_image.upload.addEventListener('progress',function(e){

      var percent = Math.round((e.loaded / e.total) * 100);
      document.querySelector(".progress-bar-image").style.width = percent + "%";
      document.querySelector(".progress-bar-image").innerHTML = percent + "%";

    });
 
    myform.append('data_type','upload_course_image');
    myform.append('tab_name',tab);
    myform.append('image',file);
    myform.append('csrf_code',document.querySelector(".js-csrf_code").value);

    ajax_course_image.open('post','',true);
    ajax_course_image.send(myform);

  }

  function ajax_course_image_cancel()
  {
    ajax_course_image.abort();
  }

  var course_video_uploading = false;
  var ajax_course_video = null;

  function upload_course_video(file)
  {

    if(course_video_uploading){

      alert("please wait while the other video uploads");
      return;
    }

    //validate video extension
    var allowed_types = ['mp4'];
    var ext = file.name.split(".").pop();
    ext = ext.toLowerCase();

    if(!allowed_types.includes(ext))
    {
      alert("Only files of this type allowed: "+allowed_types.toString(","));
      return;
    }

    //display an video preview
    var vdo = document.querySelector(".js-video-upload-preview");
    var link = URL.createObjectURL(file);
    vdo.src = link;

    //begin upload
    course_video_uploading = true;

    document.querySelector(".js-video-upload-info").innerHTML = file.name;
    document.querySelector(".js-video-upload-info").classList.remove("hide");
    document.querySelector(".js-video-upload-input").classList.add("hide");
    document.querySelector(".js-video-upload-cancel-button").classList.remove("hide");

    var myform = new FormData();
    ajax_course_video = new XMLHttpRequest();

    ajax_course_video.addEventListener('readystatechange',function(){

      if(ajax_course_video.readyState == 4){

        if(ajax_course_video.status == 200){
          //everything went well
          //alert("upload complete");
          //alert(ajax_course_video.responseText);
        }

        course_video_uploading = false;
        document.querySelector(".js-video-upload-info").classList.add("hide");
        document.querySelector(".js-video-upload-input").classList.remove("hide");
        document.querySelector(".js-video-upload-cancel-button").classList.add("hide");

      }
    });

    ajax_course_video.addEventListener('error',function(){
      alert("an error occurred");
    });

    ajax_course_video.addEventListener('abort',function(){
      alert("upload aborted");
    });

    ajax_course_video.upload.addEventListener('progress',function(e){

      var percent = Math.round((e.loaded / e.total) * 100);
      document.querySelector(".progress-bar-video").style.width = percent + "%";
      document.querySelector(".progress-bar-video").innerHTML = percent + "%";

    });
 
    myform.append('data_type','upload_course_video');
    myform.append('tab_name',tab);
    myform.append('video',file);
    myform.append('csrf_code',document.querySelector(".js-csrf_code").value);

    ajax_course_video.open('post','',true);
    ajax_course_video.send(myform);

  }

  function ajax_course_video_cancel()
  {
    ajax_course_video.abort();
  }

</script>


<script>

  var intended_learners = 
  {
    students_learn: {
      minimum_inputs:  4,
      inputs_count:  0,
    },
    
    prerequisites: {
      minimum_inputs:   1,
      inputs_count:  0,
    },

    whose_course: {
      minimum_inputs:    1,
      inputs_count:  0,
    },

    item_to_drag:     null,
    item_to_drag_to:  null,

    add_new: function(section, obj){

        var id = section.replace("js-","");
        id = id.replaceAll("-","_");
 
        var mydiv = document.createElement('div');
        mydiv.classList.add('row');
        mydiv.classList.add('js-input');
        mydiv.classList.add('my-4');
        mydiv.setAttribute('style','margin-left:2px;margin-right:2px;');
        mydiv.setAttribute('onclick','intended_learners.tab_action(event)');
        mydiv.setAttribute('ondragstart','intended_learners.tab_dragstart(event)');
        mydiv.setAttribute('ondragover','intended_learners.tab_dragover(event)');
        mydiv.setAttribute('ondragend','intended_learners.tab_drop(event)');
        mydiv.setAttribute('draggable','true');

        var min = 1;
        if(section == 'js-students-learn')
        {
          min = intended_learners.students_learn.minimum_inputs;
        }else 
        if(section == 'js-prerequisites')
        {
          min = intended_learners.prerequisites.minimum_inputs;
        }else 
        if(section == 'js-whose-course')
        {
          min = intended_learners.whose_course.minimum_inputs
        }

        //add a value of none exists
        if(typeof obj.value == 'undefined')
          obj.value = "";

        mydiv.innerHTML = `

            <input value="${obj.value}" type="text" class="col-md-9 py-2" name="${obj.name}_${intended_learners[id].inputs_count}" placeholder="${obj.placeHolder}">
            <div id="delete" min="${min}" class="col-md-1 text-center border" style="cursor:pointer;">
                <i id="delete" min="${min}" class="bi bi-trash-fill text-danger fs-4"></i>
            </div>
            <div class="col-md-1 text-center border d-flex" style="cursor:pointer;" >
              <i id="move-up" class="bi bi-caret-up-fill fs-4"></i>
              <i id="move-down" class="bi bi-caret-down-fill fs-4"></i>
            </div>
            <div id="move" class="col-md-1 text-center border" style="cursor:pointer;">
              <i class="bi bi-arrows-move fs-4"></i>
            </div>
            
        `;

        document.querySelector('.'+section).appendChild(mydiv);
        intended_learners[id].inputs_count++;
      
    },

    tab_action: function(e)
    {

        var action = e.target.id;
        var min = parseInt(e.target.getAttribute("min"));

        if(action == 'delete')
        {

          if(e.currentTarget.parentNode.children.length <= min)
          {
            alert(`You cant delete this item. You need a minimum of ${min} items`);
            return;
          }

          if(!confirm("Are you sure you want to delete this item?!"))
          {
            return;
          }

          e.currentTarget.remove();
          something_changed(e);

        }else 
        if(action == 'move-up')
        {

          var to_move   = e.currentTarget;
          var move_to   = e.currentTarget.previousElementSibling;
          var container = e.currentTarget.parentNode;

          if(move_to)
            container.insertBefore(to_move, move_to);

          something_changed(e);

        }else 
        if(action == 'move-down')
        {
          
          var to_move   = e.currentTarget;
          var move_to   = e.currentTarget.nextElementSibling.nextElementSibling;
          var container = e.currentTarget.parentNode;

          container.insertBefore(to_move, move_to);
          something_changed(e);
        }
    },

    handle_result: function(result)
    {
      intended_learners.load_inputs(result);
    },

    get_meta: function(course_id)
    {
      var obj = {};
      obj.data_type = "get-meta";
      obj.tab_name = tab;
      obj.course_id = course_id;
 
      send_data(obj);
    },

    load_inputs: function(data = [])
    {

        //for students learn section
        if(data.length == 0)
        {
          for (var i = 0; i < intended_learners.students_learn.minimum_inputs; i++) {
          
            intended_learners.add_new('js-students-learn',{
              placeHolder:'Example: Define the roles and responsibilities of a project manager',
              name:'students-learn'
            });
            
          }

          //for prerequisites section
          for (var i = 0; i < intended_learners.prerequisites.minimum_inputs; i++) {
          
            intended_learners.add_new('js-prerequisites',{
              placeHolder:'Example: No programming experience needed. You will learn everything you need to know',
              name:'prerequisites',
            });
            
          }

          //for prerequisites section
          for (var i = 0; i < intended_learners.whose_course.minimum_inputs; i++) {
          
            intended_learners.add_new('js-whose-course',{
              placeHolder:'Example: Beginner Python developers curious about data science',
              name:'whose-course',
            });
            
          }

        }else{
          
          let max = data.length;
          for (var i = max - 1; i >= 0; i--) {
          
            if(data[i].data_type == 'students-learn')
            {
              intended_learners.add_new('js-students-learn',{
                placeHolder:'Example: Define the roles and responsibilities of a project manager',
                name:'students-learn',
                value:data[i].value,
              });
            }

            //for prerequisites section
            if(data[i].data_type == 'prerequisites')
            {
              intended_learners.add_new('js-prerequisites',{
                placeHolder:'Example: No programming experience needed. You will learn everything you need to know',
                name:'prerequisites',
                value:data[i].value,
              });
            }
 
            //for prerequisites section
            if(data[i].data_type == 'whose-course')
            {
              intended_learners.add_new('js-whose-course',{
                placeHolder:'Example: Beginner Python developers curious about data science',
                name:'whose-course',
                value:data[i].value,
              });
            }

          }
            
 
        }


    },

    tab_dragstart: function(e)
    {

      intended_learners.item_to_drag = e.currentTarget;
    },

    tab_dragover: function(e)
    {
      intended_learners.item_to_drag_to = e.currentTarget;
    },

    tab_drop: function(e)
    {
      intended_learners.item_to_drag_to.parentNode.insertBefore(intended_learners.item_to_drag, intended_learners.item_to_drag_to);
      something_changed(e);
    },

  }

</script>

<script>

  var curriculum = 
  {
    curriculum: {
      minimum_inputs:  0,
      inputs_count:  0,
    },
    
    item_to_drag:     null,
    item_to_drag_to:  null,

    add_new: function(section, obj){

        var id = section.replace("js-","");
        id = id.replaceAll("-","_");
 
        var mydiv = document.createElement('div');
        mydiv.classList.add('row');
        mydiv.classList.add('js-input');
        mydiv.classList.add('my-4');
        mydiv.setAttribute('style','margin-left:2px;margin-right:2px;');
        mydiv.setAttribute('onclick','curriculum.tab_action(event)');
        mydiv.setAttribute('ondragstart','curriculum.tab_dragstart(event)');
        mydiv.setAttribute('ondragover','curriculum.tab_dragover(event)');
        mydiv.setAttribute('ondragend','curriculum.tab_drop(event)');
        mydiv.setAttribute('draggable','true');

        var min = 1;
        if(section == 'js-curriculum')
        {
          min = curriculum.curriculum.minimum_inputs;
        }

        //add a value of none exists
        if(typeof obj.value == 'undefined')
          obj.value = "";
        
        if(typeof obj.uid == 'undefined')
          obj.uid = "";

        if(typeof obj.description == 'undefined')
          obj.description = "";

        mydiv.innerHTML = `

            <div class="border row p-2 bg-light shadow">
              
              <div class="col-md-9 py-2">
                <input value="${obj.value}" type="text" uid="${obj.uid}" class="col-md-12 py-2" index="${curriculum[id].inputs_count}" name="${obj.name}_${curriculum[id].inputs_count}" placeholder="${obj.placeHolder}">
                <input value="${obj.description}" type="text" class="col-md-12 py-2" name="description_${obj.name}_${curriculum[id].inputs_count}" placeholder="Enter a description">
              </div>
              <div id="delete" min="${min}" class="col-md-1 text-center border align-items-center d-flex" style="cursor:pointer;">
                  <i id="delete" min="${min}" class="bi bi-trash-fill text-danger fs-4"></i>
              </div>
              <div class="col-md-1 text-center border d-flex align-items-center d-flex" style="cursor:pointer;" >
                <i id="move-up" class="bi bi-caret-up-fill fs-4"></i>
                <i id="move-down" class="bi bi-caret-down-fill fs-4"></i>
              </div>
              <div id="move" class="col-md-1 text-center border align-items-center d-flex" style="cursor:pointer;">
                <i class="bi bi-arrows-move fs-4"></i>
              </div>
                <hr>
                  <div>Lectures:</div>
                  <div class="col-sm-12 js-lecture-${curriculum.curriculum.inputs_count}" >

                  </div>
                <br>
              <button onclick="lecture.add_new('js-lecture-${curriculum.curriculum.inputs_count}',{placeHolder:'Enter lecture title',name:'lecture',uid:'${obj.uid}',index:'${curriculum[id].inputs_count}'})" type="button" class="btn btn-sm btn-primary js-lecture-add" style="width:130px">+ Add lecture</button>
            </div>
        `;

        //add lecture inputs with data if available
        lecture.curriculum_id = curriculum.curriculum.inputs_count;
                
        document.querySelector('.'+section).appendChild(mydiv);
        curriculum[id].inputs_count++;

        if(typeof obj.data == 'object')
          lecture.load_inputs(obj.data);
    },

    tab_action: function(e)
    {

        var action = e.target.id;
        var min = parseInt(e.target.getAttribute("min"));

        if(action == 'delete')
        {

          if(e.currentTarget.parentNode.children.length <= min)
          {
            alert(`You cant delete this item. You need a minimum of ${min} items`);
            return;
          }

          if(!confirm("Are you sure you want to delete this item?!"))
          {
            return;
          }

          e.currentTarget.remove();
          something_changed(e);

        }else 
        if(action == 'move-up')
        {

          var to_move   = e.currentTarget;
          var move_to   = e.currentTarget.previousElementSibling;
          var container = e.currentTarget.parentNode;

          if(move_to)
            container.insertBefore(to_move, move_to);

          something_changed(e);

        }else 
        if(action == 'move-down')
        {
          
          var to_move   = e.currentTarget;
          var move_to   = e.currentTarget.nextElementSibling.nextElementSibling;
          var container = e.currentTarget.parentNode;

          container.insertBefore(to_move, move_to);
          something_changed(e);
        }
    },

    handle_result: function(result)
    {
      curriculum.load_inputs(result);
    },

    get_meta: function(course_id)
    {
      var obj = {};
      obj.data_type = "get-meta";
      obj.tab_name = tab;
      obj.course_id = course_id;
 
      send_data(obj);
    },

    load_inputs: function(data = [])
    {

        //for students learn section
        if(data.length == 0)
        {
          for (var i = 0; i < curriculum.curriculum.minimum_inputs; i++) {
          
            curriculum.add_new('js-curriculum',{
              placeHolder:'Enter a title',
              name:'curriculum'
            });
            
          }

        }else{
          
          let max = data.length;
          for (var i = max - 1; i >= 0; i--) {
          
            if(data[i].data_type == 'curriculum')
            {
              curriculum.add_new('js-curriculum',{
                placeHolder:'Enter a title',
                name:'curriculum',
                value:data[i].value,
                uid:data[i].uid,
                description:data[i].description,
                data: data[i].lectures || false,
              });
            }

          }
            
 
        }


    },

    tab_dragstart: function(e)
    {

      curriculum.item_to_drag = e.currentTarget;
    },

    tab_dragover: function(e)
    {
      curriculum.item_to_drag_to = e.currentTarget;
    },

    tab_drop: function(e)
    {
      curriculum.item_to_drag_to.parentNode.insertBefore(curriculum.item_to_drag, curriculum.item_to_drag_to);
      something_changed(e);
    },

  }

</script>

<script>

  var lecture = 
  {
    root: "<?=ROOT?>",
    lecture: {
      minimum_inputs:  0,
      inputs_count:  0,
    },
    curriculum_id: 0,
    item_to_drag:     null,
    item_to_drag_to:  null,

    add_new: function(section, obj){

        var id = section.replace("js-","");
        id = id.replaceAll("-","_");
 
        var mydiv = document.createElement('div');
        mydiv.classList.add('row');
        mydiv.classList.add('js-input');
        mydiv.classList.add('my-4');
        mydiv.setAttribute('style','margin-left:2px;margin-right:2px;');
        mydiv.setAttribute('onclick','lecture.tab_action(event)');
        mydiv.setAttribute('ondragstart','lecture.tab_dragstart(event)');
        mydiv.setAttribute('ondragover','lecture.tab_dragover(event)');
        mydiv.setAttribute('ondragend','lecture.tab_drop(event)');
        mydiv.setAttribute('draggable','true');

        var min = 1;

        min = lecture.lecture.minimum_inputs;

        //add a value of none exists
        if(typeof obj.value == 'undefined')
          obj.value = "";
        
        if(typeof obj.uid == 'undefined')
          obj.uid = "";
        
        if(typeof obj.index == 'undefined')
          obj.index = "";

        if(typeof obj.description == 'undefined')
          obj.description = "";

        if(typeof obj.file == 'undefined')
          obj.file = "";
        
        if(typeof obj.base_file == 'undefined')
          obj.base_file = "";
        
        mydiv.innerHTML = `

            <div class="col-md-8 py-2">
              <input value="${obj.value}" type="text" uid="${obj.uid}"  index="${obj.index}" class="col-md-12 py-2" name="${obj.name}_${lecture['lecture'].inputs_count}_curriculum_${obj.index}" placeholder="${obj.placeHolder}">
              <input value="${obj.description}" type="text" class="col-md-12 py-2" name="description_${obj.name}_${lecture['lecture'].inputs_count}_curriculum_${obj.index}" placeholder="Enter a description">
              <input value="${obj.base_file}" type="text" class="col-md-12 py-2" name="file_${obj.name}_${lecture['lecture'].inputs_count}_curriculum_${obj.index}" placeholder="Video file">
              <div>Video file:(mp4 100mb max)</div>
              <input type="file" name="new_file_${obj.name}_${lecture['lecture'].inputs_count}_curriculum_${obj.index}">`;

              if(obj.file.match("no_video.jpg")){
                  mydiv.innerHTML += `
                    <div class="col-md-12 py-2"><img src="${obj.file}" style="border:solid thin #ccc;width:50%;"></div>
                  `;
              }else{
                mydiv.innerHTML += `
                <video controls class="col-md-12 py-2">
                  <source type="video/mp4" src="${obj.file}"></source>
                </video>`;
              }

        mydiv.innerHTML += `
            </div>
            <div id="delete" min="${min}" class="col-md-1 text-center border align-items-center d-flex" style="cursor:pointer;">
                <i id="delete" min="${min}" class="bi bi-trash-fill text-danger fs-4"></i>
            </div>
            <div class="col-md-1 text-center border d-flex align-items-center " style="cursor:pointer;" >
              <i id="move-up" class="bi bi-caret-up-fill fs-4"></i>
              <i id="move-down" class="bi bi-caret-down-fill fs-4"></i>
            </div>
            <div id="move" class="col-md-1 text-center border align-items-center d-flex" style="cursor:pointer;">
              <i class="bi bi-arrows-move fs-4"></i>
            </div>
            
        `;

        document.querySelector('.'+section).appendChild(mydiv);
        lecture['lecture'].inputs_count++;
      
    },

    tab_action: function(e)
    {
        e.stopPropagation();

        var action = e.target.id;
        var min = parseInt(e.target.getAttribute("min"));

        if(action == 'delete')
        {

          if(e.currentTarget.parentNode.children.length <= min)
          {
            alert(`You cant delete this item. You need a minimum of ${min} items`);
            return;
          }

          if(!confirm("Are you sure you want to delete this item?!"))
          {
            return;
          }

          e.currentTarget.remove();
          something_changed(e);

        }else 
        if(action == 'move-up')
        {

          var to_move   = e.currentTarget;
          var move_to   = e.currentTarget.previousElementSibling;
          var container = e.currentTarget.parentNode;

          if(move_to)
            container.insertBefore(to_move, move_to);

          something_changed(e);

        }else 
        if(action == 'move-down')
        {
          
          var to_move   = e.currentTarget;
          var move_to   = e.currentTarget.nextElementSibling.nextElementSibling;
          var container = e.currentTarget.parentNode;

          container.insertBefore(to_move, move_to);
          something_changed(e);
        }
    },

    handle_result: function(result)
    {
      lecture.load_inputs(result);
    },

    get_meta: function(course_id)
    {
      var obj = {};
      obj.data_type = "get-meta";
      obj.tab_name = tab;
      obj.course_id = course_id;
 
      send_data(obj);
    },

    load_inputs: function(data = [])
    {

        //for students learn section
        if(data.length == 0)
        {
          for (var i = 0; i < lecture.lecture.minimum_inputs; i++) {
          
            lecture.add_new('js-lecture-'+lecture.curriculum_id,{
              placeHolder:'Enter lecture title',
              name:'lecture'
            });

          }

        }else{
          
          let max = data.length;
          for (var i = max - 1; i >= 0; i--) {
          
              lecture.add_new('js-lecture-'+lecture.curriculum_id,{
                placeHolder:'Enter lecture title',
                name:'lecture',
                index:lecture.curriculum_id,
                value:data[i].title,
                uid:data[i].uid,
                description:data[i].description,
                file:data[i].file,
                base_file:data[i].base_file,
              });

          }
            
 
        }


    },

    tab_dragstart: function(e)
    {

      lecture.item_to_drag = e.currentTarget;
    },

    tab_dragover: function(e)
    {
      lecture.item_to_drag_to = e.currentTarget;
    },

    tab_drop: function(e)
    {
      lecture.item_to_drag_to.parentNode.insertBefore(lecture.item_to_drag, lecture.item_to_drag_to);
      something_changed(e);
    },

  }

</script>

<?php $this->view('admin/admin-footer',$data) ?>