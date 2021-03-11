
<?php if (is_array($banner) && count($banner) > 1) { ?>
    <section id="banner">

        <div id="myCarousel" class="carousel slide">
            <!-- 轮播（Carousel）指标 -->
            <ol class="carousel-indicators">
                <?php for ($i = 0; $i < count($banner); $i++) { ?>
                    <li data-target="#myCarousel" data-slide-to="<?= $i ?>" <?php if ($i == 0) echo 'class="active"'; ?>></li>
                <?php } ?>
            </ol>
            <!-- 轮播（Carousel）项目 -->
            <div class="carousel-inner">
                <?php foreach ($banner as $k => $v) { ?>
                    <div class="item <?php if ($k == 0) echo 'active'; ?>" >
                        <img src="<?= $v ?>"/>
                    </div>
                <?php } ?>
            </div>

            <!-- 轮播（Carousel）导航 -->
            <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

    </section>

<?php } elseif (is_array($banner) && count($banner) == 1) { $item = array_pop($banner); ?>
    <section id="banner">
        <img src="<?= $item ?>">
    </section>
<?php } elseif (is_string($banner)) { ?>
    <section id="banner">
        <img src="<?= $banner ?>">
    </section>
<?php } ?>
