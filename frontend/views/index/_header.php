<?php
/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 3/14/15
 * Time: 14:27
 */

use yii\helpers\Html;

?>
<div class="pre-loader">
    <div class="load-con">
        <img src="img/berry/logo.png" class="animated fadeInDown" alt="">

        <div class="spinner">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>
    </div>
</div>

<header>

    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1">
                    <span class="fa fa-bars fa-lg"></span>
                </button>
                <a class="navbar-brand" href="/">
                    <img src="img/berry/logo.png" alt="" class="logo">
                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#about">overview</a></li>
                    <li><a href="#features">features</a></li>
                    <li><a href="#reviews">reviews</a></li>
                    <li><a href="#screens">screens</a></li>
                    <li><a href="#getApp">apps</a></li>
                    <li><?= Html::a('support', '/site/contact') ?></li>
                    <li><?= Html::a('login', '/site/login', ['class' => 'getApp']) ?></li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-->
    </nav>


    <!--RevSlider-->
    <div class="tp-banner-container">
        <div class="tp-banner">
            <ul>
                <!-- SLIDE  -->
                <li data-transition="fade" data-slotamount="7" data-masterspeed="1500">
                    <!-- MAIN IMAGE -->
                    <img src="img/transparent.png" alt="slidebg1" data-bgfit="cover" data-bgposition="left top"
                         data-bgrepeat="no-repeat">
                    <!-- LAYERS -->
                    <!-- LAYER NR. 1 -->
                    <div class="tp-caption lfl fadeout hidden-xs"
                         data-x="left"
                         data-y="bottom"
                         data-hoffset="30"
                         data-voffset="0"
                         data-speed="500"
                         data-start="700"
                         data-easing="Power4.easeOut">
                        <img src="img/berry/Slides/hand-berry.png" alt="">
                    </div>

                    <div class="tp-caption lfl fadeout visible-xs"
                         data-x="left"
                         data-y="center"
                         data-hoffset="700"
                         data-voffset="0"
                         data-speed="500"
                         data-start="700"
                         data-easing="Power4.easeOut">
                        <img src="img/berry/iphone-berry.png" alt="">
                    </div>

                    <div class="tp-caption large_white_bold sft" data-x="550" data-y="center" data-hoffset="0"
                         data-voffset="-80" data-speed="500" data-start="1200" data-easing="Power4.easeOut">
                        Oleose
                    </div>
                    <div class="tp-caption large_white_light sfr" data-x="770" data-y="center" data-hoffset="0"
                         data-voffset="-80" data-speed="500" data-start="1400" data-easing="Power4.easeOut">
                        App
                    </div>
                    <div class="tp-caption large_white_light sfb" data-x="550" data-y="center" data-hoffset="0"
                         data-voffset="0" data-speed="1000" data-start="1500" data-easing="Power4.easeOut">
                        Landing Theme
                    </div>

                    <div class="tp-caption sfb hidden-xs" data-x="550" data-y="center" data-hoffset="0"
                         data-voffset="85" data-speed="1000" data-start="1700" data-easing="Power4.easeOut">
                        <a href="#about" class="btn btn-primary inverse btn-lg">LEARN MORE</a>
                    </div>
                    <div class="tp-caption sfr hidden-xs" data-x="730" data-y="center" data-hoffset="0"
                         data-voffset="85" data-speed="1500" data-start="1900" data-easing="Power4.easeOut">
                        <a href="#app" class="btn btn-default btn-lg">SUPPORTED APP</a>
                    </div>

                </li>
                <!-- SLIDE 2 -->
                <li data-transition="zoomout" data-slotamount="7" data-masterspeed="1000">
                    <!-- MAIN IMAGE -->
                    <img src="img/transparent.png" alt="slidebg1" data-bgfit="cover" data-bgposition="left top"
                         data-bgrepeat="no-repeat">
                    <!-- LAYERS -->
                    <!-- LAYER NR. 1 -->
                    <div class="tp-caption lfb fadeout hidden-xs"
                         data-x="center"
                         data-y="bottom"
                         data-hoffset="0"
                         data-voffset="0"
                         data-speed="1000"
                         data-start="700"
                         data-easing="Power4.easeOut">
                        <img src="img/berry/Slides/berry-slide2.png" alt="">
                    </div>


                    <div class="tp-caption large_white_light sft" data-x="center" data-y="250" data-hoffset="0"
                         data-voffset="0" data-speed="1000" data-start="1400" data-easing="Power4.easeOut">
                        Every Pixel <i class="fa fa-heart"></i>
                    </div>


                </li>

                <!-- SLIDE 3 -->
                <li data-transition="zoomout" data-slotamount="7" data-masterspeed="1000">
                    <!-- MAIN IMAGE -->
                    <img src="img/transparent.png" alt="slidebg1" data-bgfit="cover" data-bgposition="left top"
                         data-bgrepeat="no-repeat">
                    <!-- LAYERS -->
                    <!-- LAYER NR. 1 -->
                    <div class="tp-caption customin customout hidden-xs"
                         data-x="right"
                         data-y="center"
                         data-hoffset="0"
                         data-customin="x:50;y:150;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0.5;scaleY:0.5;skewX:0;skewY:0;opacity:0;transformPerspective:0;transformOrigin:50% 50%;"
                         data-customout="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0.75;scaleY:0.75;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
                         data-voffset="50"
                         data-speed="1000"
                         data-start="700"
                         data-easing="Power4.easeOut">
                        <img src="img/berry/Slides/family-berry.png" alt="">
                    </div>

                    <div class="tp-caption customin customout visible-xs"
                         data-x="center"
                         data-y="center"
                         data-hoffset="0"
                         data-customin="x:50;y:150;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0.5;scaleY:0.5;skewX:0;skewY:0;opacity:0;transformPerspective:0;transformOrigin:50% 50%;"
                         data-customout="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0.75;scaleY:0.75;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
                         data-voffset="0"
                         data-speed="1000"
                         data-start="700"
                         data-easing="Power4.easeOut">
                        <img src="img/berry/Slides/family-berry.png" alt="">
                    </div>

                    <div class="tp-caption lfb visible-xs" data-x="center" data-y="center" data-hoffset="0"
                         data-voffset="400" data-speed="1000" data-start="1200" data-easing="Power4.easeOut">
                        <a href="#" class="btn btn-primary inverse btn-lg">Purchase</a>
                    </div>


                    <div class="tp-caption mediumlarge_light_white sfl hidden-xs" data-x="left" data-y="center"
                         data-hoffset="0" data-voffset="-50" data-speed="1000" data-start="1000"
                         data-easing="Power4.easeOut">
                        Powerful Responsive
                    </div>
                    <div class="tp-caption mediumlarge_light_white sft hidden-xs" data-x="left" data-y="center"
                         data-hoffset="0" data-voffset="0" data-speed="1000" data-start="1200"
                         data-easing="Power4.easeOut">
                        App Landing Page
                    </div>
                    <div class="tp-caption small_light_white sfb hidden-xs" data-x="left" data-y="center"
                         data-hoffset="0" data-voffset="80" data-speed="1000" data-start="1600"
                         data-easing="Power4.easeOut">
                        <p>Nulla pretium libero interdum, tempus lorem non, rutrum diam. <br> Quisque pellentesque
                            diam sed pulvinar lobortis. Vestibulum ante <br>ipsum primis in faucibus orci luctus et
                            ultrices posuere cubilia Curae.</p>
                    </div>

                    <div class="tp-caption lfl hidden-xs" data-x="left" data-y="center" data-hoffset="0"
                         data-voffset="160" data-speed="1000" data-start="1800" data-easing="Power4.easeOut">
                        <a href="#" class="btn btn-primary inverse btn-lg">Purchase</a>
                    </div>


                </li>

            </ul>
        </div>
    </div>


</header>

