    <aside id="menu">
            <div id="navigation">
               
                <ul class="nav" id="side-menu">
                        <!-- class="active" -->
                    
                    
                    <?php 
                    if($_SESSION['role']==0){
                        $masterID = $_SESSION['master'];
                        $mainString = " where id in($masterID)";
                        $menuID = $_SESSION['menu'];
                        $innerString = " and id in($menuID)";
                    }else{
                        $mainString = "";
                        $innerString = "";
                    }
                    $sql=mysqli_query($conn,"select * from $tblMenuCategory $mainString order by ordering ")or die(mysqli_error($conn));
                    while($row=mysqli_fetch_assoc($sql))
                    {
                        echo "<li><a href='#'><span class='nav-label'>
                        
                        {$row['name']}</span>
                                  <span class='fa arrow'></span> </a>";
                     $menuCID = $row['id'];             
                     $sql1=mysqli_query($conn,"select * from $tblMenu where category_id='$menuCID' $innerString")or die(mysqli_error($conn));
                        while($row1=mysqli_fetch_assoc($sql1))
                        {              
                           echo "<ul class='nav nav-second-level'>
                                                           <li>
                                                               <a href='{$row1['url']}'>
                                                                   <span class='nav-label'>
                                                                       {$row1['name']}
                                                                   </span>
                                                               </a>
                                                           </li>
                                                       </ul>" ;
                        }    
                       echo "</li>"; }?>     
                       <!-- <a href="#">
                       <span class="nav-label">Website Master</span><span class="fa arrow"></span> </a>
                       <ul class="nav nav-second-level">
                            <li>
                                <a href="career-list.php">
                                    <span class="nav-label">
                                        Career List
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="notification-list.php">
                                    <span class="nav-label">
                                        Notification List
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="promo-list.php">
                                    <span class="nav-label">
                                        Promo Code List
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="setting.php">
                                    <span class="nav-label">
                                        Website Setting
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="user-list.php">
                                    <span class="nav-label">
                                        Teacher List
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="notice-list.php">
                                    <span class="nav-label">
                                        Notice List
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="banner-list.php">
                                    <span class="nav-label">
                                        Banner List
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="testimonial-list.php">
                                    <span class="nav-label">
                                        Testimonial List
                                    </span>
                                </a>
                            </li>
                       </ul> -->
                    </li> 
                    <!-- <li>
                       <a href="#">
                       <span class="nav-label">Project Master</span><span class="fa arrow"></span> </a>
                       <ul class="nav nav-second-level">
                           <li>
                                <a href="course-list.php">
                                    <span class="nav-label">
                                        Course List
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="subject-list.php">
                                    <span class="nav-label">
                                        Subject List
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="video-list.php">
                                    <span class="nav-label">
                                        Video List
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="notes-list.php">
                                    <span class="nav-label">
                                        Notes List
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="exam-paper-list.php">
                                    <span class="nav-label">
                                        Online Test Series List
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="free-exam-paper-list.php">
                                    <span class="nav-label">
                                        Online Question Practice  List
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="live-video-list.php">
                                    <span class="nav-label">
                                        live Class List
                                    </span>
                                </a>
                            </li>
                            
                       </ul>
                    </li> 
                    <li>
                       <a href="#">
                       <span class="nav-label">Order  Master</span><span class="fa arrow"></span> </a>
                       <ul class="nav nav-second-level">
                            <li>
                                <a href="student-list.php">
                                    <span class="nav-label">
                                        Student List
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="student-result-list.php">
                                    <span class="nav-label">
                                        Student Result List
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="order-list.php">
                                    <span class="nav-label">
                                        Order List
                                    </span>
                                </a>
                            </li>
                       </ul>
                    </li>  -->
                    
                    

                    
                    
                    <!-- <li>
                       <a href="#">
                       <span class="nav-label">Booking</span><span class="fa arrow"></span> </a>
                       <ul class="nav nav-second-level">
                        <li>
                            <a href="room-booking-list.php">
                                <span class="nav-label">
                                    Room Booking List
                                </span>
                            </a>
                        </li>
                         <li>
                            <a href="food-booking-list.php">
                                <span class="nav-label">
                                    Food Booking List
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="gallery-category-list.php">
                                <span class="nav-label">
                                    Gallery Category List
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="gallery-list.php">
                                <span class="nav-label">
                                    Gallery  List
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="enquiry-list.php">
                                <span class="nav-label">
                                    Enquiry List
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="book-list.php">
                                <span class="nav-label">
                                    Booking List
                                </span>
                            </a>
                        </li>
                       </ul>
                   </li> -->
                    
                    
                    
                   
                    
                    <li>
                        <a href="loginQuery/logout.php">
                            <span class="nav-label">
                                Logout
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </aside>