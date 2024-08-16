<?php
    get_header();

?>

<section class="">
   <div class="container">
    <div class="row">
            <div class="col-lg-9">
            <article id="post-<?php the_ID();?>"<?php post_class();?> >

                <?php
                    $thumbnail_id = get_post_thumbnail_id(get_the_ID());
                    $alt          = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);

                    if (empty($alt)) {
                        $alt = get_the_title();
                    }

                    if (has_post_thumbnail()) {
                        the_post_thumbnail('full', array(
                            'class' => 'card-img-top w-100',
                            'alt'   => esc_attr($alt),
                        ));
                    }
                ?>
                <h2><?php the_title();?></h2>
                <?php the_content();
                    echo '<p>Posted on ' . get_the_date() . ' by ' . get_the_author() . '</p>';
                    echo get_post_format();
                ?>

            </article>

            <div class="mt-5">
            <?php comments_template();?>

            </div>


            </div>
            <div class="col-lg-3">
            <?php get_sidebar('sidbar_1');?>
            </div>
        </div>
   </div>
</section>

<?php
    get_footer();

?>