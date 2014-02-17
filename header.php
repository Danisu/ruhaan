<?php ?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link href="<?php bloginfo('stylesheet_url'); ?>" rel="stylesheet" type="text/css" media="screen" />
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div><!-- #page -->
  <header>
    <div class="hero">
      <section class="layout">
        <div class="branding"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img src="http://placekitten.com/150/150" alt=""/></a></div><!-- branding -->
      </section><!-- layout -->
    </div><!-- hero -->
    <div class="navigation">
      <section class="layout">
		<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav',) ); ?>
      </section><!-- layout -->
    </div><!-- navigation -->
  </header><!-- header -->
<div><!-- #main -->