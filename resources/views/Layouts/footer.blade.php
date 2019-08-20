  {{--
    <div class="brand-carousel container-fluid border-top border-bottom">
     <div class="row">
      <div class="col-12">
        <div class="owl-carousel owl-theme">
          <div class="item">
            <img src="{{ asset('img/isurance.png') }}" alt="Isurance" />
          </div>
          <div class="item">
            <img src="{{ asset('img/mercury.png') }}" alt="Mercury" />
          </div>
          <div class="item">
            <img src="{{ asset('img/farmers.png') }}" alt="Farmers" />
          </div>
          <div class="item">
            <img src="{{ asset('img/state-farm.png') }}" alt="State Farm" />
          </div>
          <div class="item">
            <img src="{{ asset('img/national-wide.png') }}" alt="National Wide" />
          </div>
          <div class="item">
            <img src="{{ asset('img/american-family.png') }}" alt="American Family" />
          </div>
          <div class="item">
            <img src="{{ asset('img/progressive.png') }}" alt="Progressive" />
          </div>
          <div class="item">
            <img src="{{ asset('img/liberty-mutual.png') }}" alt="Liberty Mutual" />
          </div>                        
        </div>
      </div>
    </div>
  </div>
  ---}}


  <footer class="footer">

    <div class="container">
      <div class="row">

        <div class="col-12 col-md-4 footer-box-2">
          <p class="mb-2"><a href="#"><i class="fa fa-comment"></i> Live chat</a></p>
          <p><a href="mailto:meow@quotemeow.com"><i class="fa fa-envelope"></i> meow@quotemeow.com</a></p>
        </div>
        <div class="col-12 col-md-4 col-lg-4 footer-box-1">
          <p class="mt-1">Monday-Friday | 9am-6pm PST <br> Saturday | 9am-1pm PST <br> Sunday closed</p>
        </div>        
        <div class="col-12 col-md-4 footer-box-3">
          <p>
            <img src="{{ asset('img/bbb.svg') }}" class="mr-2" />
            <img src="{{ asset('img/norton.svg') }}"/>
          </p>
          <p>
            <a  href="{{route('privacy')}}">Privacy</a> <a href="#">Terms of Services</a>
          </p>
        </div>
      </div>
    </div>
  </footer>
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
  <script src="{{ asset('js/jquery-ui.js') }}"></script>
  <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
  @stack('scripts')
  <script src="{{ asset('js/jquery.inputmask.bundle.js') }}"></script>
  <script src="{{ asset('js/script.js') }}"></script>
  <script src="{{ asset('js/review-form.js') }}"></script>
</body>
</html>