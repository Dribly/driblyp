@extends('layouts.bootstrap')
@section('htmlmetadescription','Dribly automates your watering, without crazy systems and complex installation')
@section ('headerclass')masthead
@endsection
@section('headermore')
          <hr>
          <p>Dribly automates your watering, without crazy systems and complex installation</p>
          <a class="btn btn-primary btn-xl js-scroll-trigger" href="#about">Find Out More</a>

@endsection

@section('content')

    <section class="bg-primary" id="about">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 mx-auto text-center">
            <h2 class="section-heading text-white">We've got what you need!</h2>
            <hr class="light">
            <p class="text-faded">Just attach the tap using tap connectors to your system, and use an online timer for free. Get a sensor (subscription required) and we will keep the garden watered. Monitor on our Dribly app and your garden will be watered all year when it needs it.</p>
            <a class="btn btn-default btn-xl js-scroll-trigger" href="#services">Get Started!</a>
          </div>
        </div>
      </div>
    </section>

    <section id="services">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 text-center">
            <h2 class="section-heading">At Your Service</h2>
            <hr class="primary">
          </div>
        </div>
      </div>
      <div class="container">
        <div class="row">
          <div class="col-lg-3 col-md-6 text-center">
            <div class="service-box">
              <i class="fa fa-4x fa-diamond text-primary sr-icons"></i>
              <h3>Self-charging tap</h3>
              <p class="text-muted">The batteries are charged automatically by the water from the tap</p>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 text-center">
            <div class="service-box">
              <i class="fa fa-4x fa-paper-plane text-primary sr-icons"></i>
              <h3>Time, gentlemen please</h3>
              <p class="text-muted">Use our free timer to trigger the water when you want it, or turn your sprinklers on from your armchair at the touch of a button</p>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 text-center">
            <div class="service-box">
              <i class="fa fa-4x fa-newspaper-o text-primary sr-icons"></i>
              <h3>Weather Warning</h3>
              <p class="text-muted">We let you know if it's been a bit dry.</p>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 text-center">
            <div class="service-box">
              <i class="fa fa-4x fa-heart text-primary sr-icons"></i>
              <h3>Sense and Sensibility</h3>
              <p class="text-muted">Dribly knows when it is raining, and doesn't waste your water.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="p-0" id="portfolio">
      <div class="container-fluid">
        <div class="row no-gutter popup-gallery">
          <div class="col-lg-4 col-sm-6">
            <a class="portfolio-box" href="/themes/creative/img/portfolio/fullsize/1.jpg">
              <img class="img-fluid" src="/themes/creative/img/portfolio/thumbnails/1.jpg" alt="">
              <div class="portfolio-box-caption">
                <div class="portfolio-box-caption-content">
                  <div class="project-category text-faded">
                    Simple installation
                  </div>
                  <div class="project-name">
                    Mrs Fotheringgale
                  </div>
                </div>
              </div>
            </a>
          </div>
          <div class="col-lg-4 col-sm-6">
            <a class="portfolio-box" href="/themes/creative/img/portfolio/fullsize/2.jpg">
              <img class="img-fluid" src="/themes/creative/img/portfolio/thumbnails/2.jpg" alt="">
              <div class="portfolio-box-caption">
                <div class="portfolio-box-caption-content">
                  <div class="project-category text-faded">
                    Can't get up?
                  </div>
                  <div class="project-name">
                    Disability lawn
                  </div>
                </div>
              </div>
            </a>
          </div>
          <div class="col-lg-4 col-sm-6">
            <a class="portfolio-box" href="/themes/creative/img/portfolio/fullsize/3.jpg">
              <img class="img-fluid" src="/themes/creative/img/portfolio/thumbnails/3.jpg" alt="">
              <div class="portfolio-box-caption">
                <div class="portfolio-box-caption-content">
                  <div class="project-category text-faded">
                    On holidays
                  </div>
                  <div class="project-name">
                    Watch it get wet
                  </div>
                </div>
              </div>
            </a>
          </div>
          <div class="col-lg-4 col-sm-6">
            <a class="portfolio-box" href="/themes/creative/img/portfolio/fullsize/4.jpg">
              <img class="img-fluid" src="/themes/creative/img/portfolio/thumbnails/4.jpg" alt="">
              <div class="portfolio-box-caption">
                <div class="portfolio-box-caption-content">
                  <div class="project-category text-faded">
                    Fast and free
                  </div>
                  <div class="project-name">
                    Water on the beach
                  </div>
                </div>
              </div>
            </a>
          </div>
<!--          <div class="col-lg-4 col-sm-6">
            <a class="portfolio-box" href="/themes/creative/img/portfolio/fullsize/5.jpg">
              <img class="img-fluid" src="/themes/creative/img/portfolio/thumbnails/5.jpg" alt="">
              <div class="portfolio-box-caption">
                <div class="portfolio-box-caption-content">
                  <div class="project-category text-faded">
                    Category
                  </div>
                  <div class="project-name">
                    Project Name
                  </div>
                </div>
              </div>
            </a>
          </div>
          <div class="col-lg-4 col-sm-6">
            <a class="portfolio-box" href="/themes/creative/img/portfolio/fullsize/6.jpg">
              <img class="img-fluid" src="/themes/creative/img/portfolio/thumbnails/6.jpg" alt="">
              <div class="portfolio-box-caption">
                <div class="portfolio-box-caption-content">
                  <div class="project-category text-faded">
                    Category
                  </div>
                  <div class="project-name">
                    Project Name
                  </div>
                </div>
              </div>
            </a>
          </div>-->
        </div>
      </div>
    </section>



      
@endsection
