<?php $this->view('includes/header', $data) ?>
<?php $this->view('includes/nav', $data) ?>


<?php if (!empty($images)) : ?>

  <!-- ======= Hero Slider Section ======= -->
  <section id="hero-slider" class="hero-slider">
    <div class="container-md" data-aos="fade-in">
      <div class="row">
        <div class="col-12">
          <div class="swiper sliderFeaturedPosts">
            <div class="swiper-wrapper">

              <?php foreach ($images as $image) : ?>
                <div class="swiper-slide">
                  <a href="#" class="img-bg d-flex align-items-end" style="background-image: url(<?= get_image($image->image) ?>);">
                    <div class="img-bg-inner">
                      <h2><?= esc($image->title) ?></h2>
                      <p><?= esc($image->description) ?></p>
                    </div>
                  </a>
                </div>
              <?php endforeach; ?>

            </div>
            <div class="custom-swiper-button-next">
              <span class="bi-chevron-right"></span>
            </div>
            <div class="custom-swiper-button-prev">
              <span class="bi-chevron-left"></span>
            </div>

            <div class="swiper-pagination"></div>
          </div>
        </div>
      </div>
    </div>
  </section><!-- End Hero Slider Section -->
<?php endif; ?>

<?php if (!empty($first_row)) : ?>

  <!-- ======= Post Grid Section ======= -->
  <section id="posts" class="posts">
    <div class="container" data-aos="fade-up">


      <div class="section-header d-flex justify-content-between align-items-center mb-5">
        <h2>Latest</h2>
        <div><a href="category.html" class="more">See All Latest</a></div>
      </div>


      <div class="row g-5">
        <div class="col-lg-4">

          <div class="post-entry-1 lg">
            <a href="single-post.html"><img src="<?= get_image($first_row->course_image) ?>" alt="" style="object-fit: cover;" class="img-fluid"></a>
            <div class="post-meta"><span class="date"><?= esc($first_row->category_row->category ?? 'Unknown') ?></span> <span class="mx-1">&bullet;</span> <span>Jul 5th '22</span></div>
            <h2><a href="single-post.html"><?= esc($first_row->title) ?></a></h2>
            <p class="mb-4 d-block"><?= esc($first_row->description) ?></p>

            <?php if (!empty($first_row->user_row)) : ?>
              <div class="d-flex align-items-center author">
                <div class="photo"><img src="<?= get_image($first_row->user_row->image) ?>" style="object-fit: cover;" alt="" class="img-fluid"></div>
                <div class="name">
                  <h3 class="m-0 p-0"><?= $first_row->user_row->firstname ?? 'Unknown' ?> <?= $first_row->user_row->lastname ?? 'Unknown' ?></h3>
                </div>
              </div>
            <?php endif; ?>
          </div>

        </div>


        <div class="col-lg-8">
          <div class="row g-5">
            <div class="col-lg-4 border-start custom-border">

              <?php if (!empty($rows1)) : ?>
                <?php foreach ($rows1 as $row) : ?>

                  <div class="post-entry-1">
                    <a href="single-post.html"><img src="<?= get_image($row->course_image) ?>" style="" alt="" class="img-fluid"></a>
                    <div class="post-meta"><span class="date"><?= esc($row->category_row->category ?? 'Unknown') ?></span> <span class="mx-1">&bullet;</span> <span><?= get_date($row->date) ?></span></div>
                    <h2><a href="single-post.html"><?= esc(ucfirst($row->title)) ?></a></h2>
                  </div>

                <?php endforeach; ?>
              <?php endif; ?>

            </div>
            <div class="col-lg-4 border-start custom-border">

              <?php if (!empty($rows2)) : ?>
                <?php foreach ($rows2 as $row) : ?>

                  <div class="post-entry-1">
                    <a href="single-post.html"><img src="<?= get_image($row->course_image) ?>" style="" alt="" class="img-fluid"></a>
                    <div class="post-meta"><span class="date"><?= esc($row->category_row->category ?? 'Unknown') ?></span> <span class="mx-1">&bullet;</span> <span><?= get_date($row->date) ?></span></div>
                    <h2><a href="single-post.html"><?= esc(ucfirst($row->title)) ?></a></h2>
                  </div>

                <?php endforeach; ?>
              <?php endif; ?>

            </div>

            <!-- Trending Section -->
            <div class="col-lg-4">

              <div class="trending">
                <h3>Trending</h3>
                <ul class="trending-post">

                  <?php if (!empty($trending)) : $num = 0; ?>
                    <?php foreach ($trending as $row) : $num++; ?>

                      <li>
                        <a href="single-post.html">
                          <span class="number"><?= $num ?></span>
                          <h3><?= esc($row->title) ?></h3>
                          <span class="author"><?= $first_row->user_row->firstname ?? 'Unknown' ?> <?= $first_row->user_row->lastname ?? 'Unknown' ?></span>
                        </a>
                      </li>
                    <?php endforeach; ?>
                  <?php endif; ?>

                </ul>
              </div>

            </div> <!-- End Trending Section -->
          </div>
        </div>

      </div> <!-- End .row -->
    </div>
  </section> <!-- End Post Grid Section -->

<?php endif; ?>


<?php $this->view('includes/footer', $data) ?>