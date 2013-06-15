<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>LifeBank</title>
        <link rel="stylesheet" href="../css/gumby.css">
        <link rel="stylesheet" href="../css/style.css">
        <link rel="author" href="humans.txt">
    </head>
    <body>
        <header>
            <div class="container">
                <div class="row">
                    <div class="three columns logo centered">
                        <img src="../img/logo-cw.png" alt="">
                    </div>
                </div>
            </div>
        </header>
        <section>
            <div class="container">
                <div class="row">  
                    <div class="title">
                        <h2>Register</h2>
                    </div>
                    <div class="wrapper edit-page seven columns centered">
                        <div class="centered user-profile">
                            
                            <!--div class="image circle">
                                <img src="img/avatar.jpg" alt="">
                            </div-->
                            
                        </div>
                        
                        <p>Just one more step to go...</p>
                        <p><?php echo get_error(); ?></p>
                        <!-- <div class="ten columns centered user-info">
                            <ul class="three_up tiles">
                                <li>
                                    <div>
                                        <span class="value">O+</span>
                                        <span class="title">Blood Group</span>
                                    </div>
                                </li>
                                <li>
                                    <div>
                                        <span class="value">12</span>
                                        <span class="title">Donated</span>
                                    </div>
                                </li>
                                <li>
                                    <div>
                                        <span class="value">200</span>
                                        <span class="title">Referrals</span>
                                    </div>
                                </li>
                            </ul>
                        </div> -->
                        
                        
                        <div class="edit-form">
                            <form method="post">
                                <span>
                                    
                                </span>
                                <ul class="two_up tiles">
                                    <li class="field">
                                        <span><i class="icon-user"></i></span>
                                        <input class="xwide text input" type="text" name="username" placeholder="Pick a Username" value="<?php echo $_SESSION['tmp']['username']; ?>">
                                    </li>
                                    
                                    <li class="field">
                                        <span><i class="icon-user"></i></span>
                                        <input class="xwide text input" type="text" name="name" placeholder="Your Name" value="<?php echo $_SESSION['tmp']['name']; ?>">
                                    </li>
                                    
                                    <li class="field">
                                        <span><i class="icon-mail"></i></span>
                                        <input class="xwide text input" type="text" name="email" placeholder="Your Email" value="<?php echo $_SESSION['tmp']['email']; ?>">
                                    </li>
                                    
                                    <li class="field">
                                        <span ><i class="icon-phone"></i></span>
                                        <input class="xwide text input" type="phone" name="phone" placeholder="Your Phone Number" value="<?php echo $_SESSION['tmp']['phone']; ?>">
                                    </li>
                                    
                                    <li class="field">
                                        <span><i class="icon-location"></i></span>
                                        <!--input class="xwide text input" type="text" placeholder="Your Location"-->
                                        <div class="picker">
                                          <select name="location">
                                            <option value="">&mdash;</option>
                                            <?php
                                            $locations = get_locations();
                                            foreach ($locations as $v) {
                                            ?>
                                              <option value="<?php echo $v['location_id']; ?>"><?php echo $v['name']; ?></option>
                                            <?php
                                            }
                                            ?>
                                          </select>
                                        </div>
                                    </li>
                                    
                                    <li class="field">
                                        <span><i class="icon-water"></i></span>
                                        <!--input class="xwide text input" type="text" placeholder="Your Location"-->
                                        <div class="picker">
                                        <select name="blood_type">
                                          <option value="">I am not sure</option>
                                          <?php
                                          $blood_array = array('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-');
                                          foreach ($blood_array as $v) {
                                          ?>
                                          <option value="<?php echo $v; ?>"<?php echo $v == $_SESSION['tmp']['blood_type'] ? ' selected="selected"' : ''; ?>><?php echo $v; ?></option>
                                          <?php
                                          }
                                          ?>
                                        </select>
                                        </div>
                                    </li>
                                </ul>
                                
                                <!--ul class="login-social two_up tiles">
                                    <p>Fill your profile from your social account</p>
                                    <li>
                                        <a href="" class="social-btn facebook">
                                            <i class="icon-twitter"></i>Facebook
                                        </a>
                                    </li>
                                    
                                    <li>
                                        <a href="" class="social-btn twitter">
                                            <i class="icon-twitter"></i>Twitter
                                        </a>
                                    </li>
                                </ul-->
                                   
                                <span class="btn submit">
                                    <input type="submit" value="Register">
                                </span>
                            
                                
                            </form>
                            
                            
                        </div>
                        
                        
                    </div>
                    
                </div>
            </div>
        </section>

    <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script> -->
    <script>window.jQuery || document.write('<script src="js/libs/jquery-1.9.1.min.js"><\/script>')</script>
    <script src="js/libs/gumby.js"></script>
    <script src="js/main.js"></script>
    </body>
</html>