<!doctype html>
<html
<?php language_attributes()?>
>

<head>
    <meta charset="<?php bloginfo('charset');?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head()?>
</head>

<body
<?php body_class()?>
>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container">
            <a class="navbar-brand" href="<?=esc_url(home_url())?>">
                <img src="<?=esc_url(get_theme_mod('oneblog_logo'))?>" alt="<?php bloginfo('name')?>" width="120">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                </ul> -->
                <?php
                    wp_nav_menu([
                        'theme_location' => 'primary',
                        'menu_id'        => 'my_menu',
                        'menu_class'     => 'navbar-nav ms-auto',
                    ])
                ?>
            </div>
        </div>
    </nav>