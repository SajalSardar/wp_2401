<?php
    get_header();

?>
<section class="mt-4">
        <div class="container">
            <div class="row">
                <?php
                    if (have_posts()) {
                        while (have_posts()) {
                            the_post();
                        ?>
                    <div class="col-lg-3 my-3">
                    <div class="card">
                            <?php
                                $thumbnail_id = get_post_thumbnail_id($post->ID);
                                        $alt          = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);

                                        if (empty($alt)) {
                                            $alt = get_the_title();
                                        }

                                        if (has_post_thumbnail()) {
                                            the_post_thumbnail('post-thumb', array(
                                                'class' => 'card-img-top w-100',
                                                'alt'   => esc_attr($alt),
                                            ));
                                        }
                                    ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php the_title()?></h5>
                            <p class="card-text"><?php the_content();?></p>
                            <a href="<?php the_permalink()?>" class="btn btn-primary btn-sm">Read More</a>
                        </div>
                    </div>
                </div>
                <?php
                    }
                        wp_reset_postdata();
                    }
                ?>


            </div>
        </div>
    </section>
    <?php get_footer()?>