<?php
    /*
    Template Name: Movies

     */
?>

<?php
    get_header();

?>
<section class="mt-4">
        <div class="container">
            <div class="row">
            <?php
                $args = array(
                    'post_type'      => 'movies',
                    'posts_per_page' => 10,
                );
                $loop = new WP_Query($args);
                while ($loop->have_posts()) {
                    $loop->the_post();
                ?>
                <div class="entry-content">
                    <?php the_title();
                            the_content();
                        ?>
                </div>
                <?php
                    }
                ?>
            </div>
        </div>
    </section>
    <?php get_footer()?>