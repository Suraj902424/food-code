   
<?php include 'config.php'; ?>
 <!-- Footer -->
    <footer class="bg-dark text-light">
        <div class="footer-style-two default-padding">
            <div class="container">

                <div class="footer-bottom-shape">
                    <img src="assets/img/shape/9.png" alt="Image Not Found">
                </div>

                <div class="footer-top text-center">
                    <div class="row">
                        <div class="col-lg-12">
                            <a href="#"><img src="admin/uploads/products/<?= $row['image1'] ?>" alt="Logo"></a>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Singel Item -->
                    <div class="col-lg-3 col-md-6 footer-item mt-50">
                        <div class="f-item about">
                            
                            <h4 class="widget-title">About Us</h4>
                            <p>
                                Continued at zealously necessary is Surrounded sir motionless she end literature. Gay direction neglected.
                            </p>

                            <ul class="footer-social">
                                <li>
                                    <a href="<?= $row['link1'] ?>">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= $row['link2'] ?>">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= $row['link4'] ?>">
                                        <i class="fab fa-youtube"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= $row['link3'] ?>">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                </li>
                            </ul>
                    
                        </div>
                    </div>
                    <!-- End Singel Item -->
                    <!-- Singel Item -->
                    <div class="col-lg-3 col-md-6 mt-50 footer-item pl-50 pl-md-15 pl-xs-15">
                        <div class="f-item link">
                            <h4 class="widget-title">Explore</h4>
                            <ul>
                                <li>
                                    <a href="team">Compnay Profile</a>
                                </li>
                                <li>
                                    <a href="team">About</a>
                                </li>
                                <li>
                                    <a href="get-in-touch">Help Center</a>
                                </li>
                                <!-- <li>
                                    <a href="contact-us.html">Career</a>
                                </li> -->
                                <!-- <li>
                                    <a href="about-us.html">Features</a>
                                </li> -->
                                <li>
                                    <a href="get-in-touch">Contact</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- End Singel Item -->

                    <!-- Singel Item -->
                    <div class="col-lg-3 col-md-6 footer-item  mt-50">
                        <div class="f-item contact">
                            <h4 class="widget-title">Contact Info</h4>
                            <ul>
                                <li>
                                    <div class="icon">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div class="content">
                                        <?= $row['address'] ?>
                                    </div>
                                </li>
                                <li>
                                    <div class="icon">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                    <div class="content">
                                        <a href="tel:<?= $row['phone1'] ?>"><?= $row['phone1'] ?></a> <br> <a href="tel:<?= $row['phone2'] ?>"><?= $row['phone2'] ?></a>
                                    </div>
                                </li>
                                <li>
                                    <div class="icon">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <div class="content">
                                        <a href="mailto:<?= $row['email'] ?>"><?= $row['email'] ?></a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- End Singel Item -->

                    <!-- Singel Item -->
                    <div class="col-lg-3 col-md-6 footer-item mt-50">
                        <h4 class="widget-title">Newsletter</h4>
                        <p>
                            Join our subscribers list to get the latest news and special offers.
                        </p>
                        <div class="f-item newsletter">
                            <form action="#">
                                <input type="email" placeholder="Your Email" class="form-control" name="email">
                                <button type="submit"> <i class="fas fa-arrow-right"></i></button>  
                            </form>
                        </div>
                        <fieldset>
                            <input type="checkbox" id="privacy" name="privacy">
                            <label for="privacy">I agree to the Privacy Policy</label>
                        </fieldset>
                    </div>
                    <!-- End Singel Item -->


                </div>
            </div>
        </div>
            
        <!-- Start Footer Bottom -->
        <div class="footer-bottom-two">
            
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <p>© Copyright 2025 Suraj Singh. All Rights Reserved by <a href="#"></a></p>
                    </div>
                    <div class="col-lg-6 text-end">
                        <ul>
                            <li>
                                <a href="about-us.php">Terms</a>
                            </li>
                            <!-- <li>
                                <a href="about-us.html">Privacy</a>
                            </li> -->
                            <li>
                                <a href="contact.php">Support</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
  <!-- <div id="chatbox"></div>
  <input type="text" id="userInput" placeholder="Type a message...">
  <button onclick="sendMessage()">Send</button>

  <script>
    function sendMessage() {
      let msg = document.getElementById("userInput").value;
      let chatbox = document.getElementById("chatbox");

      chatbox.innerHTML += "<div class='user'><b>You:</b> " + msg + "</div>";

      fetch("chat.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "message=" + encodeURIComponent(msg)
      })
      .then(res => res.text())
      .then(data => {
        chatbox.innerHTML += "<div class='bot'><b>Bot:</b> " + data + "</div>";
        chatbox.scrollTop = chatbox.scrollHeight;
      });

      document.getElementById("userInput").value = "";
    }
  </script> -->
