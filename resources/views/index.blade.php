<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,300,400,500,700,900" rel="stylesheet">

    <title>Pilon Records Management Bureau</title>
    <!--
    SOFTY PINKO
    https://templatemo.com/tm-535-softy-pinko
    -->

    <!-- Additional CSS Files -->
    <link rel="stylesheet" type="text/css" href="second/assets/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="second/assets/css/font-awesome.css">

    <link rel="stylesheet" href="second/assets/css/templatemo-softy-pinko.css">

</head>

<body>

<!-- ***** Preloader Start ***** -->
<div id="preloader">
    <div class="jumper">
        <div></div>
        <div></div>
        <div></div>
    </div>
</div>
<!-- ***** Preloader End ***** -->


<!-- ***** Header Area Start ***** -->
<header class="header-area header-sticky">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <!-- ***** Logo Start ***** -->
                    <a href="#" class="logo m-3">
                        <img src="second/assets/images/pilon.png" width="68px" alt="Softy Pinko"/>
                    </a>
                    <!-- ***** Logo End ***** -->
                    <!-- ***** Menu Start ***** -->
                    <ul class="nav">
                        <li><a href="#welcome" class="active">Home</a></li>
                        <li><a href="#features">How it Works</a></li>
                        <li><a href="#work-process">Our Values</a></li>
                        <li><a href="#pricing-plans">Pricing</a></li>
                        <li><a href="#contact-us">Contact Us</a></li>
                    </ul>
                    <a class='menu-trigger'>
                        <span>Menu</span>
                    </a>
                    <!-- ***** Menu End ***** -->
                </nav>
            </div>
        </div>
    </div>
</header>
<!-- ***** Header Area End ***** -->
@if(session()->has('error'))

    <div class="alert alert-danger alert-dismissible" role="alert">
        {{ session()->get('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
    </div>


@elseif(session()->has('success'))


    <div class="alert alert-success alert-dismissible" role="alert">
        {{ session()->get('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
    </div>

@endif
<!-- ***** Welcome Area Start ***** -->
<div class="welcome-area" id="welcome">

    <!-- ***** Header Text Start ***** -->
    <div class="header-text">
        <div class="container">
            <div class="row">
                <div class="offset-xl-3 col-xl-6 offset-lg-2 col-lg-8 col-md-12 col-sm-12 bg-white p-3 features-small-item">
                    <h1 class="text-primary">Our Vision</h1>
                    <h4 class="text-secondary p-2 m-2">To be the first choice data and records management service provider in Zimbabwe and beyond in this 4th industrial revolution era.</h4>
                    <a href="#features" class="main-button-slider">Discover More</a>
                </div>
            </div>
        </div>
    </div>
    <!-- ***** Header Text End ***** -->
</div>
<!-- ***** Welcome Area End ***** -->

<!-- ***** Features Small Start ***** -->
<section class="section home-feature">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <!-- ***** Features Small Item Start ***** -->
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12" data-scroll-reveal="enter bottom move 50px over 0.6s after 0.2s">
                        <div class="features-small-item">
                            <div class="icon">
                                <i><img src="second/assets/images/featured-item-01.png" alt=""></i>
                            </div>
                            <h5 class="features-title">Records Management</h5>
                            <p>Payslip is one of the most crucial record or proof of employment and one’s contribution towards their social security pension fund. Most pensioners are always found in need of lost Payslip of more than 10years contribution.
                            </p>
                        </div>
                    </div>
                    <!-- ***** Features Small Item End ***** -->

                    <!-- ***** Features Small Item Start ***** -->
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12" data-scroll-reveal="enter bottom move 50px over 0.6s after 0.4s">
                        <div class="features-small-item">
                            <div class="icon">
                                <i><img src="second/assets/images/featured-item-01.png" alt=""></i>
                            </div>
                            <h5 class="features-title">NSSA Registration</h5>
                            <p>We provide employment registration to the NSSA database for both idviduals and corperations. To check if you are registered with NSSA click <span class="text-primary"><a href="{{route('whatsapp')}}">here</a></span> and
                            be redirected to our state of the art self-service whatsapp chatbot.</p>
                        </div>
                    </div>
                    <!-- ***** Features Small Item End ***** -->

                    <!-- ***** Features Small Item Start ***** -->
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12" data-scroll-reveal="enter bottom move 50px over 0.6s after 0.6s">
                        <div class="features-small-item">
                            <div class="icon">
                                <i><img src="second/assets/images/featured-item-01.png" alt=""></i>
                            </div>
                            <h5 class="features-title">NSSA Pension Application</h5>
                            <p>Life pension application is one of the most time consuming and long processes that most old aged pensioners face once they retire.PRMB offers convenient service of applying for employee’s life pensions to all pensioners. </p>
                        </div>
                    </div>
                    <!-- ***** Features Small Item End ***** -->
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ***** Features Small End ***** -->

<!-- ***** Features Big Item Start ***** -->
<section class="section padding-top-70 padding-bottom-0" id="features">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-md-12 col-sm-12 align-self-center" data-scroll-reveal="enter left move 30px over 0.6s after 0.4s">
                <img src="second/assets/images/left-image.png" class="rounded img-fluid d-block mx-auto" alt="App">
            </div>
            <div class="col-lg-1"></div>
            <div class="col-lg-6 col-md-12 col-sm-12 align-self-center mobile-top-fix">
                <div class="left-heading">
                    <h2 class="section-title">Let’s discuss about your future</h2>
                </div>
                <div class="left-text">
                    <p>You can call us on 0776477673 or send us a whatsapp message on 0776477673 and we will call you back.
                    Our dedicated team of professionals will walk you through our policies regarding how we will keep your records safe
                    and make sure you get fully compensated when you retire. In case of your untimely demise we will make sure your loved ones
                    face no challenges in collected your pension funds.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="hr"></div>
            </div>
        </div>
    </div>
</section>
<!-- ***** Features Big Item End ***** -->

<!-- ***** Features Big Item Start ***** -->
<section class="section padding-bottom-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-12 col-sm-12 align-self-center mobile-bottom-fix">
                <div class="left-heading">
                    <h2 class="section-title">We can help you to register with NSSA</h2>
                </div>
                <div class="left-text">
                    <p>Most people in Zimbabwe are not formally employed and so have never been registered in the NSSA database. We
                    at Pilon Records Management Bureau make the process as easy as clicking a few buttons. Click <span class="text-primary"><a href="{{route('whatsapp')}}">here</a></span> to use
                    our whatsapp chatbot to check if you are registered with NSSA and to register if you are not. For organisations look to do mass registration contact us on 0776477673</p>
                </div>
            </div>
            <div class="col-lg-1"></div>
            <div class="col-lg-5 col-md-12 col-sm-12 align-self-center mobile-bottom-fix-big" data-scroll-reveal="enter right move 30px over 0.6s after 0.4s">
                <img src="second/assets/images/right-image.png" class="rounded img-fluid d-block mx-auto" alt="App">
            </div>
        </div>
    </div>
</section>
<!-- ***** Features Big Item End ***** -->

<!-- ***** Home Parallax Start ***** -->
<section class="mini" id="work-process">
    <div class="mini-content">
        <div class="container">
            <div class="row">
                <div class="offset-lg-3 col-lg-6">
                    <div class="info">
                        <h1>Our Values</h1>
                        <p>To provide excellent, efficient, and reliable data and records management to our customers using simple modern technologies that ensures that crucial business data and records are managed efficiently and are creating  various sources of value to our clients.
                        </p>
                    </div>
                </div>
            </div>

            <!-- ***** Mini Box Start ***** -->
            <div class="row">
                <div class="col-lg-2 col-md-3 col-sm-6 col-6">
                    <a href="#" class="mini-box">
                        <i><img src="second/assets/images/values.png" width="50px" alt=""></i>
                        <strong>Get Ideas</strong>
                        <span>Innovation and creativity.</span>
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-6 col-6">
                    <a href="#" class="mini-box">
                        <i><img src="second/assets/images/values.png" width="50px" alt=""></i>
                        <strong>Honesty</strong>
                        <span>Honesty and integrity.</span>
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-6 col-6">
                    <a href="#" class="mini-box">
                        <i><img src="second/assets/images/values.png" width="50px" alt=""></i>
                        <strong>Diligence</strong>
                        <span>Professional client service</span>
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-6 col-6">
                    <a href="#" class="mini-box">
                        <i><img src="second/assets/images/values.png" width="50px" alt=""></i>
                        <strong>Care</strong>
                        <span>Caring for the people.</span>
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-6 col-6">
                    <a href="#" class="mini-box">
                        <i><img src="second/assets/images/values.png" width="50px" alt=""></i>
                        <strong>Team</strong>
                        <span>Teamwork and corporation.</span>
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-6 col-6">
                    <a href="#" class="mini-box">
                        <i><img src="second/assets/images/values.png" width="50px" alt=""></i>
                        <strong>Network</strong>
                        <span>Communication & understanding</span>
                    </a>
                </div>
            </div>
            <!-- ***** Mini Box End ***** -->
        </div>
    </div>
</section>
<!-- ***** Home Parallax End ***** -->


<!-- ***** Pricing Plans Start ***** -->
<section class="section colored" id="pricing-plans">
    <div class="container">
        <!-- ***** Section Title Start ***** -->
        <div class="row">
            <div class="col-lg-12">
                <div class="center-heading">
                    <h2 class="section-title">Pricing Plans</h2>
                </div>
            </div>
            <div class="offset-lg-3 col-lg-6">
                <div class="center-text">
                    <p>Below are our pricing tiers and the services offered along with it</p>
                </div>
            </div>
        </div>
        <!-- ***** Section Title End ***** -->

        <div class="row">
            <!-- ***** Pricing Item Start ***** -->
            <div class="col-lg-4 col-md-6 col-sm-12" data-scroll-reveal="enter bottom move 50px over 0.6s after 0.2s">
                <div class="pricing-item">
                    <div class="pricing-header">
                        <h3 class="pricing-title">Starter</h3>
                    </div>
                    <div class="pricing-body">
                        <div class="price-wrapper">
                            <span class="currency">$</span>
                            <span class="price">9.99</span>
                            <span class="period">Annual</span>
                        </div>
                        <ul class="list">
                            <li class="active">NSSA Registration</li>
                            <li class="active">Payslip Storage</li>
                            <li class="active">Quarterly Follow ups</li>
                            <li>NSSA Self Service Portal Management</li>
                            <li>NSSA Pension Registration</li>
                            <li>Employment Records Storage</li>
                            <li>Dependant Pension Collection Assistance</li>
                        </ul>
                    </div>
                    <div class="pricing-footer">
                        <a href="#" class="main-button">Purchase Now</a>
                    </div>
                </div>
            </div>
            <!-- ***** Pricing Item End ***** -->

            <!-- ***** Pricing Item Start ***** -->
            <div class="col-lg-4 col-md-6 col-sm-12" data-scroll-reveal="enter bottom move 50px over 0.6s after 0.4s">
                <div class="pricing-item active">
                    <div class="pricing-header">
                        <h3 class="pricing-title">Premium</h3>
                    </div>
                    <div class="pricing-body">
                        <div class="price-wrapper">
                            <span class="currency">$</span>
                            <span class="price">14.99</span>
                            <span class="period">Annual</span>
                        </div>
                        <ul class="list">
                            <li class="active">NSSA Registration</li>
                            <li class="active">Payslip Storage</li>
                            <li class="active">Monthly Follow ups</li>
                            <li class="active">NSSA Self Service Portal Management</li>
                            <li class="active">NSSA Pension Registration</li>
                            <li>Employment Records Storage</li>
                            <li>Dependant Pension Collection Assistance</li>
                        </ul>
                    </div>
                    <div class="pricing-footer">
                        <a href="#" class="main-button">Purchase Now</a>
                    </div>
                </div>
            </div>
            <!-- ***** Pricing Item End ***** -->

            <!-- ***** Pricing Item Start ***** -->
            <div class="col-lg-4 col-md-6 col-sm-12" data-scroll-reveal="enter bottom move 50px over 0.6s after 0.6s">
                <div class="pricing-item">
                    <div class="pricing-header">
                        <h3 class="pricing-title">Advanced</h3>
                    </div>
                    <div class="pricing-body">
                        <div class="price-wrapper">
                            <span class="currency">$</span>
                            <span class="price">19.99</span>
                            <span class="period">Annual</span>
                        </div>
                        <ul class="list">
                            <li class="active">NSSA Registration</li>
                            <li class="active">Payslip Storage</li>
                            <li class="active">Bi Monthly Follow ups</li>
                            <li class="active">NSSA Self Service Portal Management</li>
                            <li class="active">NSSA Pension Registration</li>
                            <li class="active">Employment Records Storage</li>
                            <li class="active">Dependant Pension Collection Assistance</li>
                        </ul>
                    </div>
                    <div class="pricing-footer">
                        <a href="#" class="main-button">Purchase Now</a>
                    </div>
                </div>
            </div>
            <!-- ***** Pricing Item End ***** -->
        </div>
    </div>
</section>
<!-- ***** Pricing Plans End ***** -->

<!-- ***** Contact Us Start ***** -->
<section class="section colored" id="contact-us">
    <div class="container">
        <!-- ***** Section Title Start ***** -->
        <div class="row">
            <div class="col-lg-12">
                <div class="center-heading">
                    <h2 class="section-title">Talk To Us</h2>
                </div>
            </div>
            <div class="offset-lg-3 col-lg-6">
                <div class="center-text">
                    <p>Drop your details below and we will call you today!</p>
                </div>
            </div>
        </div>
        <!-- ***** Section Title End ***** -->

        <div class="row">
            <!-- ***** Contact Text Start ***** -->
            <div class="col-lg-4 col-md-6 col-sm-12">
                <h5 class="margin-bottom-30">Keep in touch</h5>
                <div class="contact-text">
                    <p>23, Sealous Avenue,
                        <br>Harare, Zimbabwe</p>
                    <p>Contact us on:
                    <br>Email:
                    <br>Phone:0776477673</p>
                </div>
            </div>
            <!-- ***** Contact Text End ***** -->

            <!-- ***** Contact Form Start ***** -->
            <div class="col-lg-8 col-md-6 col-sm-12">


                <div class="contact-form">
                    <form id="contact" action="{{route('save-messages')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <fieldset>
                                    <input name="name" type="text" class="form-control" id="name" placeholder="Full Name" required>
                                </fieldset>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <fieldset>
                                    <input name="email" type="email" class="form-control" id="email" placeholder="E-Mail Address" required>
                                </fieldset>
                            </div>
                            <div class="col-lg-12">
                                <fieldset>
                                    <textarea name="message" rows="6" class="form-control" id="message" placeholder="Your Message" required></textarea>
                                </fieldset>
                            </div>
                            <div class="col-lg-12">
                                <fieldset>
                                    <button type="submit" id="form-submit" class="main-button">Send Message</button>
                                </fieldset>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- ***** Contact Form End ***** -->
        </div>
    </div>
</section>
<!-- ***** Contact Us End ***** -->

<!-- ***** Footer Start ***** -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <ul class="social">
                    <li><a href="https://www.facebook.com/profile.php?id=100089713475530"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="https://www.instagram.com/pilonrecordsmanagement/"><i class="fa fa-instagram"></i></a></li>
                    <li><a href="https://wa.me/263776477673"><i class="fa fa-whatsapp"></i></a></li>

                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <p class="copyright">Copyright &copy; 2023 Pilon Records Management Bureau</p>
            </div>
        </div>
    </div>
</footer>

<!-- jQuery -->
<script src="second/assets/js/jquery-2.1.0.min.js"></script>

<!-- Bootstrap -->
<script src="second/assets/js/popper.js"></script>
<script src="second/assets/js/bootstrap.min.js"></script>

<!-- Plugins -->
<script src="second/assets/js/scrollreveal.min.js"></script>
<script src="second/assets/js/waypoints.min.js"></script>
<script src="second/assets/js/jquery.counterup.min.js"></script>
<script src="second/assets/js/imgfix.min.js"></script>

<!-- Global Init -->
<script src="second/assets/js/custom.js"></script>

</body>
</html>
