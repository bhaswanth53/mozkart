<?php
    require "local.php";
    require "check.php";
    function generate_otp() {
        $numbers = '0123456789';
        $generated_numbers = substr(str_shuffle($numbers),0,6);
        $final_otp = substr(str_shuffle($generated_numbers),0,6);
        return $final_otp;
    }
    /* function protect($con, $string) {
        $string = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $string);
        $string = mysqli_real_escape_string($con, trim(strip_tags(addslashes($string))));
        return $string;
    } */

    echo protect($con, "bhaswanth<script>alert('1');</script>");
    echo "<br><br>";

    echo md5(base64_encode(generate_otp()));

    print_r($_POST);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Mozcart - Homepage</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
        <link href="./assets/demo/demo.css" rel="stylesheet" />
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="//fonts.googleapis.com/icon?family=Material+Icons">
        <link href="//fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="./assets/demo/demo.css" rel="stylesheet" />
        <link href="./assets/css/material-kit.css?v=2.0.3" rel="stylesheet" />
        <link rel="stylesheet" href="css/uikit.min.css" />
        <link href="//fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="css/style.css"/>
        <script src="js/uikit.min.js"></script>
        <script src="js/uikit-icons.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
<style>
  .wrapper {
  margin: 0 auto;
  width: 80%;
  text-align: center;
}

.image-gallery {
  margin: 0 auto;
  display: table;
}

.primary,
.thumbnails {
  display: table-cell;
}

.thumbnails {
  width: 300px;

}

.primary {
  width: 600px;
  height: 400px;
  background-color: #cccccc;
  background-size: cover;
  background-position: center center;
  background-repeat: no-repeat;
}

.thumbnail:hover .thumbnail-image {
  border: 4px solid red;
}

.thumbnail-image {
  width: 100px;
  height: 100px;
  margin: 20px auto;
  background-size: cover;
  background-position: center center;
  background-repeat: no-repeat;
  border: 4px solid transparent;
}


.count-input {
  position: relative;
  width: 100%;
  max-width: 165px;
  margin: 10px 0;
}
.count-input input {
  width: 100%;
  height: 36.92307692px;
  border: 1px solid #000;
  border-radius: 2px;
  background: none;
  text-align: center;
}
.count-input input:focus {
  outline: none;
}
.count-input .incr-btn {
  display: block;
  position: absolute;
  width: 30px;
  height: 30px;
  font-size: 26px;
  font-weight: 300;
  text-align: center;
  line-height: 30px;
  top: 50%;
  right: 0;
  margin-top: -15px;
  text-decoration:none;
}
.count-input .incr-btn:first-child {
  right: auto;
  left: 0;
  top: 46%;
}
.count-input.count-input-sm {
  max-width: 125px;
}
.count-input.count-input-sm input {
  height: 36px;
}
.count-input.count-input-lg {
  max-width: 200px;
}
.count-input.count-input-lg input {
  height: 70px;
  border-radius: 3px;
}

.price-box {
  margin: 0 auto;
  background: #E9E9E9;
  border-radius: 10px;
  padding: 40px 15px;
  width: 500px;
}

.ui-widget-content {
  border: 1px solid #bdc3c7;
  background: #e1e1e1;
  color: #222222;
  margin-top: 4px;
}

.ui-slider .ui-slider-handle {
  position: absolute;
  z-index: 2;
  width: 5.2em;
  height: 2.2em;
  cursor: default;
  margin: 0 -40px auto !important;
  text-align: center;
  line-height: 30px;
  color: #FFFFFF;
  font-size: 15px;
  .glyphicon {
    color: #FFFFFF;
    margin: 0 3px;
    font-size: 11px;
    opacity: 0.5;
  }
}

.ui-corner-all {
  border-radius: 20px;
}

.ui-slider-horizontal .ui-slider-handle {
  top: -.9em;
}

.ui-state-default, .ui-widget-content .ui-state-default {
  border: 1px solid #f9f9f9;
  background: #3F51B5;
	width: auto;
  min-width: 100px;
}

.ui-slider-horizontal .ui-slider-handle {
  margin-left: -0.5em;
}

.ui-slider {
  .ui-slider-handle {
    cursor: pointer;
  }
  a {
    cursor: pointer;
    outline: none;
    &:focus {
      cursor: pointer;
      outline: none;
    }
  }
}

.price, .lead p {
  font-weight: 600;
  font-size: 32px;
  display: inline-block;
  line-height: 60px;
}

h4.great {
  background: #3F51B5;
  margin: 0 0 25px -60px;
  padding: 7px 15px;
  color: #ffffff;
  font-size: 18px;
  font-weight: 600;
  border-radius: 5px;
  display: inline-block;
  -moz-box-shadow: 2px 4px 5px 0 #ccc;
  -webkit-box-shadow: 2px 4px 5px 0 #ccc;
  box-shadow: 2px 4px 5px 0 #ccc;
}

.total {
  /*display: inline;
  padding: 10px 5px;*/
  position: relative;
  padding-bottom: 20px;
}

.price-slider {
  margin-bottom: 70px;
  span {
    font-weight: 200;
    display: inline-block;
    color: #7f8c8d;
    font-size: 13px;
  }
}

.form-pricing {
  background: #ffffff;
  padding: 20px;
  border-radius: 4px;
}

.price-form {
  background: #ffffff;
  margin-bottom: 10px;
  padding: 20px;
  border: 1px solid #eeeeee;
  border-radius: 4px;
  	/*-moz-box-shadow:    0 5px 5px 0 #ccc;
    	-webkit-box-shadow: 0 5px 5px 0 #ccc;
    	box-shadow:         0 5px 5px 0 #ccc;*/
}

.form-group {
  margin-bottom: 0;
  span.price {
    font-weight: 200;
    display: inline-block;
    color: #7f8c8d;
    font-size: 14px;
  }
}

.help-text {
  display: block;
  margin-top: 32px;
  margin-bottom: 10px;
  color: #737373;
  position: absolute;
  /*margin-left: 20px;*/
  font-weight: 200;
  text-align: right;
  width: 188px;
}

.price-form label {
  font-weight: 200;
  font-size: 21px;
}

img.payment {
  display: block;
  margin-left: auto;
  margin-right: auto;
}

.ui-slider-range-min {
  background: #3F51B5;
}

/* HR */

hr.style {
  margin-top: 0;
  border: 0;
  border-bottom: 1px dashed #ccc;
  background: #999;
}
</style>
    </head>
    <body>
      <!--<div class="container pad">
        <div class="wrapper">
          <header>
          <h1>Product Image Gallery with Thumbnails</h1>
          <p>Click on the thumbnail to view it larger on the right!</p>
          </header>

          <div class="image-gallery">
            <aside class="thumbnails">
              <a href="#" class="selected thumbnail" data-big="http://placekitten.com/420/600">
                <div class="thumbnail-image" style="background-image: url(http://placekitten.com/420/600)"></div>
              </a>
              <a href="#" class="thumbnail" data-big="http://placekitten.com/450/600">
                <div class="thumbnail-image" style="background-image: url(http://placekitten.com/450/600)"></div>
              </a>
              <a href="#" class="thumbnail" data-big="http://placekitten.com/460/700">
                <div class="thumbnail-image" style="background-image: url(http://placekitten.com/460/700)"></div>
              </a>
            </aside>

          <main class="primary" style="background-image: url('http://placekitten.com/420/600');"></main>
          </div>

        </div>
      </div>-->

      <div class="container pad">
        <div class="row">
          <div class="col-md-4 col-lg-2">
              <div class="row image-gallery">
                <div class="col-4 col-lg-12">
                  <a href="#" class="selected thumbnail" data-big="http://placekitten.com/420/600">
                    <div class="thumbnail-image" style="background-image: url(http://placekitten.com/420/600)"></div>
                  </a>
                </div>
                <div class="col-4 col-lg-12">
                  <a href="#" class="thumbnail" data-big="http://placekitten.com/450/600">
                    <div class="thumbnail-image" style="background-image: url(http://placekitten.com/450/600)"></div>
                  </a>
                </div>
                <div class="col-4 col-lg-12">
                  <a href="#" class="thumbnail" data-big="http://placekitten.com/460/700">
                    <div class="thumbnail-image" style="background-image: url(http://placekitten.com/460/700)"></div>
                  </a>
                </div>
              </div>
          </div>
          <div class="col-md-8 col-lg-5">
            <main class="primary" style="background-image: url('http://placekitten.com/420/600');"></main>
          </div>
          <div class="col-md-12 col-lg-5"></div>
        </div>
      </div>

      <div class="container">
	                        <div class="count-input space-bottom">
                                <a class="incr-btn" data-action="decrease" href="#">–</a>
                                <input class="quantity" type="text" name="quantity" value="1"/>
                                <a class="incr-btn" data-action="increase" href="#">&plus;</a>
                            </div>
</div>
            
        
        <input type="checkbox">Checkbox

<a href="test.php?login">Login</a>
<a href="test.php?signup">Signup</a>
        <div class="modal fade login" id="loginModal" tabindex="-1" role="">
          <div class="modal-dialog modal-login" role="document">
              <div class="modal-content">
                  <div class="card card-signup card-plain">
                      <div class="modal-header">
                          <div class="card-header card-header-primary text-center">
                              <h4 class="card-title">Log in</h4>
                              <div class="social-line">
                                  <a href="#pablo" class="btn btn-just-icon btn-link">
                                      <i class="fa fa-facebook-square"></i>
                                  </a>
                                  <a href="#pablo" class="btn btn-just-icon btn-link">
                                      <i class="fa fa-twitter"></i>
                                  </a>
                                  <a href="#pablo" class="btn btn-just-icon btn-link">
                                      <i class="fa fa-google-plus"></i>
                                  <div class="ripple-container"></div></a>
                              </div>
                          </div>
                      </div>
                      <div class="modal-body">
                          <form class="form" method="" action="">
                              <div class="card-body">

                                  <div class="form-group bmd-form-group">
                                      <div class="input-group">
                                          <span class="input-group-addon">
                                              <i class="material-icons">face</i>
                                          </span>
                                          <input type="text" class="form-control" placeholder="First Name...">
                                      </div>
                                  </div>

                                  <div class="form-group bmd-form-group">
                                      <div class="input-group">
                                          <span class="input-group-addon">
                                              <i class="material-icons">lock_outline</i>
                                          </span>
                                          <input type="password" placeholder="Password..." class="form-control">
                                      </div>
                                  </div>
                                  <div class="form-group">
                                  </div>
                              </div>
                              <a href="#pablo" class="btn btn-primary">Login</a>
                          <a href="" class="btn btn-link btn-primary">Forgot password?</a>
                          </form>
                      </div>
                      <div class="modal-footer justify-content-center">
                          Not a member? <a href="test.php?signup" class="btn btn-link btn-primary">Get Started</a>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <div class="modal fade signup" id="loginModal" tabindex="-1" role="">
          <div class="modal-dialog modal-login" role="document">
              <div class="modal-content">
                  <div class="card card-signup card-plain">
                      <div class="modal-header">
                          <div class="card-header card-header-primary text-center">
                              <h4 class="card-title">Signup</h4>
                              <div class="social-line">
                                  <a href="#pablo" class="btn btn-just-icon btn-link">
                                      <i class="fa fa-facebook-square"></i>
                                  </a>
                                  <a href="#pablo" class="btn btn-just-icon btn-link">
                                      <i class="fa fa-twitter"></i>
                                  </a>
                                  <a href="#pablo" class="btn btn-just-icon btn-link">
                                      <i class="fa fa-google-plus"></i>
                                  <div class="ripple-container"></div></a>
                              </div>
                          </div>
                      </div>
                      <div class="modal-body">
                          <form class="form" method="" action="">
                              <div class="card-body">

                                  <div class="form-group bmd-form-group">
                                      <div class="input-group">
                                          <span class="input-group-addon">
                                              <i class="material-icons">face</i>
                                          </span>
                                          <input type="text" class="form-control" placeholder="Username">
                                      </div>
                                  </div>
                                  <div class="form-group bmd-form-group">
                                      <div class="input-group">
                                          <span class="input-group-addon">
                                              <i class="material-icons">email</i>
                                          </span>
                                          <input type="text" class="form-control" placeholder="Email">
                                      </div>
                                  </div>

                                  <div class="form-group bmd-form-group">
                                      <div class="input-group">
                                          <span class="input-group-addon">
                                              <i class="material-icons">lock_outline</i>
                                          </span>
                                          <input type="password" placeholder="Password" class="form-control">
                                      </div>
                                  </div>
                                  <div class="form-group bmd-form-group">
                                      <div class="input-group">
                                          <span class="input-group-addon">
                                              <i class="material-icons">lock_outline</i>
                                          </span>
                                          <input type="password" placeholder="Confirm Password" class="form-control">
                                      </div>
                                  </div>
                                  <div class="form-group">
                                  </div>
                              </div>
                              <a href="#pablo" class="btn btn-primary">Get started</a>
                          </form>
                      </div>
                      <div class="modal-footer justify-content-center">
                          Already have an account? <a href="test.php?login" class="btn btn-link btn-primary">Login</a>
                      </div>
                  </div>
              </div>
          </div>
      </div>

                        <div class="color-checkboxes">
                            <input class="color-checkbox__input" type="checkbox" id="col-Pink" value="#e91e63" name="colour"/>
                            <label class="color-checkbox Pink" for="col-Pink" id="col-Pink-label" style="background: #e91e63"></label>

                            <input class="color-checkbox__input" type="checkbox" id="col-Purple" value="#673ab7" name="colour"/>
                            <label class="color-checkbox Purple" for="col-Purple" id="col-Purple-label" style="background: #673ab7"></label>

                            <input class="color-checkbox__input" type="checkbox" id="col-Blue" value="#2196f3" name="colour"/>
                            <label class="color-checkbox Blue" for="col-Blue" id="col-Blue-label" style="background: #2196f3"></label>

                            <input class="color-checkbox__input" type="checkbox" id="col-Green" value="#8bc34a" name="colour"/>
                            <label class="color-checkbox Green" for="col-Green" id="col-Green-label" style="background: #8bc34a"></label>

                            <input class="color-checkbox__input" type="checkbox" id="col-Yellow" value="#fdd835" name="colour"/>
                            <label class="color-checkbox Yellow" for="col-Yellow" id="col-Yellow-label" style="background: #fdd835"></label>

                            <input class="color-checkbox__input" type="checkbox" id="col-Orange" value="#ff9800" name="colour"/>
                            <label class="color-checkbox Orange" for="col-Orange" id="col-Orange-label" style="background: #ff9800"></label>

                            <input class="color-checkbox__input" type="checkbox" id="col-Red" value="#f44336" name="colour"/>
                            <label class="color-checkbox Red" for="col-Red" id="col-Red-label" style="background: #f44336"></label>			
                        </div>


        <div class="container pad">
            <form action="" method="POST">
                <fieldset class="uk-fieldset">
                    <legend class="uk-legend">Edit your profile</legend>
                    <div class="uk-margin">
                        <div class="form-group">
                            <label for="name" class="bmd-label-floating">Name</label>
                            <input type="text" class="form-control" id="name">
                        </div>
                    </div>
                    <div class="uk-margin">
                        <div class="form-group">
                            <label class="label-control">Date Of Birth</label>
                            <input type="text" class="form-control datetimepicker" value="10/05/2016"/>
                        </div>
                    </div>
                    <div class="uk-margin">
                        <div class="form-group">
                            <label for="email" class="bmd-label-floating">Email</label>
                            <input type="email" class="form-control" id="email">
                        </div>
                    </div>
                    <div class="uk-margin">
                        <div class="form-group">
                            <label for="mobile" class="bmd-label-floating">Mobile</label>
                            <input type="mobile" class="form-control" id="mobile">
                        </div>
                    </div>
                    <div class="uk-margin">
                         <div class="form-check form-check-radio form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1"> Male
                                <span class="circle">
                                    <span class="check"></span>
                                </span>
                            </label>
                            </div>
                            <div class="form-check form-check-radio form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2"> Female
                                <span class="circle">
                                    <span class="check"></span>
                                </span>
                            </label>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
        <div class="container pad">
            <form action="" method="POST">
                <fieldset class="uk-fieldset">
                    <legend class="uk-legend">Edit your profile</legend>
                    <div class="uk-margin">
                        <input type="text" class="uk-input" name="name" placeholder="Name">
                    </div>
                    <div class="uk-margin">
                        <input type="email" class="uk-input" name="email" placeholder="Email">
                    </div>
                    <div class="uk-margin">
                        <input type="text" class="uk-input" name="mobile" placeholder="Mobile">
                    </div>
                    <div class="uk-margin">
                        <div class="form-check form-check-radio form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1"> Male
                                <span class="circle">
                                    <span class="check"></span>
                                </span>
                            </label>
                            </div>
                            <div class="form-check form-check-radio form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2"> Female
                                <span class="circle">
                                    <span class="check"></span>
                                </span>
                            </label>
                        </div>
                    </div>
                    <div class="uk-margin address_wrap">
                        <textarea class="uk-textarea" rows="5" placeholder="Textarea" name="address[]"></textarea>
                        <a href="javascript:void(0);" class="btn btn-primary" id="add_address">Add</a>
                    </div>
                </fieldset>
            </form>
        </div>
        <div class="container pad">
            <div class="row">
                <div class="col-md-3">
                    <div class="card" style="">
                        <img class="card-img-top" src="img/a.jpg" alt="Card image cap">
                        <div class="card-body">
                            <h4 class="card-title text-primary">Product Name</h4>
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td class="text-primary">Quantity</td>
                                        <td>2</td>
                                    </tr>
                                    <tr>
                                        <td class="text-primary">Price</td>
                                        <td>$20.00</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card" style="">
                        <img class="card-img-top" src="img/a.jpg" alt="Card image cap">
                        <div class="card-body">
                            <h4 class="card-title text-primary">Product Name</h4>
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td class="text-primary">Quantity</td>
                                        <td>2</td>
                                    </tr>
                                    <tr>
                                        <td class="text-primary">Price</td>
                                        <td>$20.00</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card" style="">
                        <img class="card-img-top" src="img/a.jpg" alt="Card image cap">
                        <div class="card-body">
                            <h4 class="card-title text-primary">Product Name</h4>
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td class="text-primary">Quantity</td>
                                        <td>2</td>
                                    </tr>
                                    <tr>
                                        <td class="text-primary">Price</td>
                                        <td>$20.00</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card" style="">
                        <img class="card-img-top" src="img/a.jpg" alt="Card image cap">
                        <div class="card-body">
                            <h4 class="card-title text-primary">Product Name</h4>
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td class="text-primary">Quantity</td>
                                        <td>2</td>
                                    </tr>
                                    <tr>
                                        <td class="text-primary">Price</td>
                                        <td>$20.00</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container pad">
            <div id="slider"></div>
        </div>
        <div class="container pad">
            <form action="" method="POST" name="first" id="first">
                <input type="hidden" name="name" value="Bhaswanth">
                <input type="hidden" name="class" value="cse">
            </form>
            <form action="" method="POST" name="second" id="second">
                <input type="hidden" name="branch" value="nbkr">
                <input type="submit" name="submit" value="submit">
            </form>
        </div>
        <div uk-filter="target: .js-filter">

    <ul class="uk-subnav uk-subnav-pill">
        <li class="uk-active" uk-filter-control="sort: data-date"><a href="#">Ascending</a></li>
        <li uk-filter-control="sort: data-date; order: desc"><a href="#">Descending</a></li>
    </ul>

    <ul class="js-filter uk-child-width-1-2 uk-child-width-1-3@m uk-text-center" uk-grid>
        <li data-date="2016-06-01">
            <div class="uk-card uk-card-default uk-card-body">2016-06-01</div>
        </li>
        <li data-date="2016-12-13">
            <div class="uk-card uk-card-primary uk-card-body">2016-12-13</div>
        </li>
        <li data-date="2017-05-20">
            <div class="uk-card uk-card-default uk-card-body">2017-05-20</div>
        </li>
        <li data-date="2017-09-17">
            <div class="uk-card uk-card-default uk-card-body">2017-09-17</div>
        </li>
        <li data-date="2017-11-03">
            <div class="uk-card uk-card-secondary uk-card-body">2017-11-03</div>
        </li>
        <li data-date="2017-12-25">
            <div class="uk-card uk-card-secondary uk-card-body">2017-12-25</div>
        </li>
        <li data-date="2018-01-30">
            <div class="uk-card uk-card-primary uk-card-body">2018-01-30</div>
        </li>
        <li data-date="2018-02-01">
            <div class="uk-card uk-card-secondary uk-card-body">2018-02-01</div>
        </li>
        <li data-date="2018-03-11">
            <div class="uk-card uk-card-primary uk-card-body">2018-03-11</div>
        </li>
        <li data-date="2018-06-13">
            <div class="uk-card uk-card-default uk-card-body">2018-06-13</div>
        </li>
        <li data-date="2018-10-27">
            <div class="uk-card uk-card-primary uk-card-body">2018-10-27</div>
        </li>
        <li data-date="2018-12-02">
            <div class="uk-card uk-card-secondary uk-card-body">2018-12-02</div>
        </li>
    </ul>

</div>
        <script src="./assets/js/core/bootstrap-material-design.min.js" type="text/javascript"></script>
        <script src="./assets/js/core/popper.min.js" type="text/javascript"></script>
        <script src="./assets/js/plugins/moment.min.js"></script>
        <script src="./assets/js/plugins/bootstrap-datetimepicker.js" type="text/javascript"></script>
        <script src="./assets/js/plugins/nouislider.min.js" type="text/javascript"></script>
        <script src="./assets/js/material-kit.js?v=2.0.3" type="text/javascript"></script>
        <script src="js/scroll.js" type="text/javascript"></script>
        <script src="js/slider.js" type="text/javascript"></script>
        <script src="js/date_time.js" type="text/javascript"></script>
        <script src="js/dynamic_fields.js" type="text/javascript"></script>
        <script src="//getuikit.com/assets/uikit/dist/js/uikit.js?nc=7576"></script>
        <script>
            $('.thumbnail').on('click', function() {
              var clicked = $(this);
              var newSelection = clicked.data('big');
              var $img = $('.primary').css("background-image","url(" + newSelection + ")");
              clicked.parent().find('.thumbnail').removeClass('selected');
              clicked.addClass('selected');
              $('.primary').empty().append($img.hide().fadeIn('slow'));
            });
        </script>
        <script>
        $(".incr-btn").on("click", function (e) {
        var $button = $(this);
        var oldValue = $button.parent().find('.quantity').val();
        $button.parent().find('.incr-btn[data-action="decrease"]').removeClass('inactive');
        if ($button.data('action') == "increase") {
            var newVal = parseFloat(oldValue) + 1;
        } else {
            // Don't allow decrementing below 1
            if (oldValue > 1) {
                var newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 1;
                $button.addClass('inactive');
            }
        }
        $button.parent().find('.quantity').val(newVal);
        e.preventDefault();
    });
        </script>
          <script type="text/javascript">
              $(document).ready(function(){
                  $('input[type="checkbox"]').click(function(){
                      if($(this).prop("checked") == true){
                          alert("Checkbox is checked.");
                      }
                      else if($(this).prop("checked") == false){
                          alert("Checkbox is unchecked.");
                      }
                  });
              });
          </script>
          <script>
            if(window.location.href.indexOf("login") > -1) {
              $('.login').modal('show');
            }
            if(window.location.href.indexOf("signup") > -1) {
              $('.signup').modal('show');
            }
          </script>
          <script>
            $(function() {
                $("form[name='second']").on('submit', function() {
                    $("form[name='first']").submit();
                });
            });
          </script>
    </body>
</html>