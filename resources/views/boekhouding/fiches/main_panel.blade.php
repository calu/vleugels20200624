      <div class="main-panel">
        <div class="content-wrapper">
           @include('boekhouding.fiches.betaling')	
           @include('boekhouding.fiches.reservatie')
           @include('boekhouding.fiches.client')
           @include('boekhouding.fiches.factuuradres')
           @include('boekhouding.fiches.kamer')		
           @include('boekhouding.fiches.contactpersoon') 
        <!-- content-wrapper ends -->
      
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2018 <a href="https://www.urbanui.com/" target="_blank">Urbanui</a>. All rights reserved.</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="mdi mdi-heart text-danger"></i></span>
          </div>
        </footer>
        <!-- partial -->
      </div>