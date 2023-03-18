<form>
	<div class="col-md-8 mx-auto">

		<?php csrf() ?>

		<div class="my-4 h5"><b>Course Landing page</b></div>

		<div class="input-group mb-3">
			<span class="input-group-text" id="basic-addon1">Course Title</span>
			<input value="<?= $row->title ?>" name="title" type="text" class="form-control">
			<small class="error error-title w-100 text-danger"></small>
		</div>

		<div class="input-group mb-3">
			<span class="input-group-text" id="basic-addon1">Course subtitle</span>
			<input value="<?= $row->subtitle ?>" name="subtitle" type="text" class="form-control">
			<small class="error error-subtitle w-100 text-danger"></small>
		</div>

		<div class="row mb-3">
			<label for="inputPassword" class="col-sm-2 col-form-label"><b>Description</b></label>
			<div class="col-sm-10">
				<textarea name="description" class="form-control" style="height: 100px"><?= $row->description ?></textarea>
			</div>
			<small class="error error-description w-100 text-danger"></small>
		</div>


		<div class="row">
			<div class="col-md-6 my-3">
				<select name="language_id" class="form-select">
					<option value="">--Select Language--</option>
					<?php if (!empty($languages)) : ?>
						<?php foreach ($languages as $cat) : ?>
							<?php
							$row->language_id = !$row->language_id ? 21 : $row->language_id;
							?>
							<option <?= set_select('language_id', $cat->id, $row->language_id) ?> value="<?= $cat->id ?>"><?= esc($cat->language) ?></option>
						<?php endforeach; ?>
					<?php endif; ?>
				</select>
				<small class="error error-language_id w-100 text-danger"></small>
			</div>
			<div class="col-md-6 my-3">
				<select name="level_id" class="form-select">
					<option value="">--Select Level--</option>
					<?php if (!empty($levels)) : ?>
						<?php foreach ($levels as $cat) : ?>
							<option <?= set_select('level_id', $cat->id, $row->level_id) ?> value="<?= $cat->id ?>"><?= esc($cat->level) ?></option>
						<?php endforeach; ?>
					<?php endif; ?>
				</select>
				<small class="error error-level_id w-100 text-danger"></small>
			</div>
			<div class="col-md-6 my-3">
				<select name="category_id" class="form-select">
					<option value="">--Select Category--</option>
					<?php if (!empty($categories)) : ?>
						<?php foreach ($categories as $cat) : ?>
							<option <?= set_select('category_id', $cat->id, $row->category_id) ?> value="<?= $cat->id ?>"><?= esc($cat->category) ?></option>
						<?php endforeach; ?>
					<?php endif; ?>

				</select>
				<small class="error error-category_id w-100 text-danger"></small>
			</div>
			<div class="col-md-6 my-3">
				<select name="sub_category_id" class="form-select">
					<option value="">--Select Subcategory--</option>
				</select>
				<small class="error error-sub_category_id w-100 text-danger"></small>
			</div>

			<label><b>Pricing:</b></label>
			<div class="col-md-4 mb-4">
				<select name="currency_id" class="form-select">
					<option value="">--Select Currency--</option>
					<?php if (!empty($currencies)) : ?>
						<?php foreach ($currencies as $cat) : ?>
							<option <?= set_select('currency_id', $cat->id, $row->currency_id) ?> value="<?= $cat->id ?>"><?= esc($cat->currency . " ($cat->symbol)") ?></option>
						<?php endforeach; ?>
					<?php endif; ?>
				</select>
				<small class="error error-currency_id w-100 text-danger"></small>
			</div>
			<div class="col-md-8 mb-4">
				<select name="price_id" class="form-select">
					<option value="">--Select Price--</option>
					<?php if (!empty($prices)) : ?>
						<?php foreach ($prices as $cat) : ?>
							<option <?= set_select('price_id', $cat->id, $row->price_id) ?> value="<?= $cat->id ?>"><?= esc($cat->name . " ($cat->price)") ?></option>
						<?php endforeach; ?>
					<?php endif; ?>
				</select>
				<small class="error error-price_id w-100 text-danger"></small>
			</div>

		</div>

		<div class="input-group mb-3">
			<span class="input-group-text" id="basic-addon1">Primary Subject</span>
			<input value="<?= $row->primary_subject ?>" name="primary_subject" type="text" class="form-control">
			<small class="error error-primary_subject w-100 text-danger"></small>
		</div>


		<div class="my-4 row">
			<div class="col-sm-4">
				<img class="js-image-upload-preview" src="<?= get_image($row->course_image) ?>" style="width: 100%;height: 220px;object-fit: cover;">
			</div>
			<div class="col-sm-8">
				<div class="h5"><b>Course Image:</b></div>
				Upload your course image here. It must meet our course image quality standards to be accepted. Important guidelines: 750x422 pixels; .jpg, .jpeg,. gif, or .png. no text on the image.

				<br><br>
				<input onchange="upload_course_image(this.files[0])" class="js-image-upload-input" type="file" name="">
				<div class="progress my-4">
					<div class="progress-bar progress-bar-image" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
				</div>
				<div class="js-image-upload-info hide"></div>
				<button type="button" onclick="ajax_course_image_cancel()" class="js-image-upload-cancel-button btn btn-warning text-white btn-sm hide">Cancel Upload</button>
			</div>
		</div>

		<div class="my-4 row">
			<div class="col-sm-4">

				<video controls class="js-video-upload-preview" style="width: 100%;">
					<source src="$row->course_promo_video" type="video/mp4">
				</video>
			</div>
			<div class="col-sm-8">
				<div class="h5"><b>Course Video:</b></div>
				Students who watch a well-made promo video are 5X more likely to enroll in your course. We've seen that statistic go up to 10X for exceptionally awesome videos. Learn how to make yours awesome!

				<br><br>
				<input onchange="upload_course_video(this.files[0])" class="js-video-upload-input" type="file" name="">
				<div class="progress my-4">
					<div class="progress-bar progress-bar-video" role="progressbar" style="width: 0%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">0%</div>
				</div>
				<div class="js-video-upload-info hide"></div>
				<button type="button" onclick="ajax_course_video_cancel()" class="js-video-upload-cancel-button btn btn-warning text-white btn-sm hide">Cancel Upload</button>
			</div>
		</div>


	</div>
</form>