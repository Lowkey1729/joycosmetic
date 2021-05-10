 <!-- ##### Newsletter Area Start ##### -->
 <section class="newsletter-area section-padding-100-0" style="background:#231818;">
     <div class="container">
         <div class="row align-items-center">
             <!-- Newsletter Text -->
             <div class="col-12 col-lg-6 col-xl-7">
                 <div class="newsletter-text mb-100">
                     <h2>Subscribe for a <span>25% Discount</span></h2>
                     <p>Nulla ac convallis lorem, eget euismod nisl. Donec in libero sit amet mi vulputate consectetur.
                         Donec auctor interdum purus, ac finibus massa bibendum nec.</p>
                         <p>Address: Lagos,Nigeria.</p>
                         <p>Contact: 08132809870.</p>
                 </div>
             </div>
             <!-- Newsletter Form -->
             <div class="col-12 col-lg-6 col-xl-5">
                 <div class="newsletter-form mb-100">
                     <form action="#" method="post">
                         <input type="email" name="email" class="nl-email" placeholder="Your E-mail">
                         <input type="submit" value="Subscribe">
                     </form>
                 </div>
             </div>
         </div>
     </div>
 </section>
 <!-- ##### Newsletter Area End ##### -->

 <!-- ##### Footer Area Start ##### -->
 <footer class="footer_area clearfix" style="background:#010f13;">
     <div class="container">
         <div class="row align-items-center">
             <!-- Single Widget Area -->
             <div class="col-12 col-lg-4">
                 <div class="single_widget_area">
                     <!-- Logo -->
                     <div class="footer-logo mr-50">
                         <a href="index.html"><img src="img/core-img/logo.png" alt=""></a>
                     </div>
                     <!-- Copywrite Text -->
                     <p class="copywrite">
                         <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                         Copyright &copy;<script>
                         document.write(new Date().getFullYear());
                         </script> All rights reserved , Joy Cosmetics<br>
                         Address: Lagos, Nigeria.<br>
                         Contact: 08132809870.
                         <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                     </p>
                 </div>
             </div>
             <!-- Single Widget Area -->
             <div class="col-12 col-lg-8">
                 <div class="single_widget_area">
                     <!-- Footer Menu -->
                     <div class="footer_menu">
                         <nav class="navbar navbar-expand-lg justify-content-end">
                             <button class="navbar-toggler" type="button" data-toggle="collapse"
                                 data-target="#footerNavContent" aria-controls="footerNavContent" aria-expanded="false"
                                 aria-label="Toggle navigation"><i class="fa fa-bars"></i></button>
                             <div class="collapse navbar-collapse" id="footerNavContent">
                                 <ul class="navbar-nav ml-auto">
                                     <li class="nav-item active">
                                         <a class="nav-link" href="/">Home</a>
                                     </li>
                                     <li class="nav-item">
                                         <a class="nav-link" href="{{url('/shop')}}">Shop</a>
                                     </li>
                                     <li class="nav-item">
                                         <a class="nav-link" href="{{url('/cart/client/cart')}}">Cart</a>
                                     </li>
                                     @guest
                                     @else
                                     <li class="nav-item">
                                         <a class="nav-link"
                                             href="{{url('/shop/show-order/'.Auth::user()->id)}}">Orders</a>
                                     </li>
                                     @endguest


                                 </ul>
                             </div>
                         </nav>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </footer>
 <!-- ##### Footer Area End ##### -->

 <!-- ##### jQuery (Necessary for All JavaScript Plugins) ##### -->
 <script src="{{asset('js/jquery/jquery-2.2.4.min.js')}}"></script>
 <!-- Popper js -->
 <script src="{{asset('js/popper.min.js')}}"></script>
 <!-- Bootstrap js -->
 <script src="{{asset('js/bootstrap.min.js')}}"></script>
 <!-- Plugins js -->
 <script src="{{asset('js/plugins.js')}}"></script>
 <!-- Active js -->
 <script src="{{asset('js/active.js')}}"></script>
 <!-- Data Tables JS -->
 <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js" type="text/javascript"></script>
 </body>

 </html>
