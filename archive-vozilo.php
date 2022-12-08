<?php
    get_header();
    $sImageUrl = get_template_directory_uri().'/img/home.jpg';
    echo '
    <!-- Page Header -->
    <header class="masthead" style="background-image: url('.$sImageUrl.')">
    <div class="container">
        <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <div class="site-heading">
            <h1>Vozila</h1>
            <span class="subheading"></span>
            </div>
        </div>
        </div>
    </div>
    </header>';	
?>
<div id="divVozila"><?php DajSvaVozila()?></div>
<div class="modal fade" id="ModalRegistracija" tabindex="-1" role="dialog" aria-labelledby="ModalRegistracija" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content text-black">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalRegistracija">Registracija vozila</h5>
          <span aria-hidden="true" class="btn btn-sm btn-danger" data-bs-dismiss="modal"><i class="fa fa-window-close"></i></span>
      </div>
      <div class="modal-body">
        Jeste li sigurni da želite registrirati vozilo <b id="nazivVozila"></b>?
      </div>
      <div class="modal-footer">
        <input id="voziloID" val="" hidden>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Odustani</button>
        <button type="button" id="liveToastBtn" class="btn btn-primary"  onclick="RegistrirajVozilo()" >Registriraj</button>
      </div>
    </div>
  </div>
</div>
<div id="tost" class="position-fixed bottom-0 right-0 p-3" aria-live="polite" aria-atomic="true">
  <div id="tostDodavanje" class="toast" data-animation="true" data-delay="2000">
    <div class="toast-header bg-primary text-white">
      <span><i class="fa fa-check" aria-hidden="true"></i></span>
      <strong class="me-auto ml-1">Obavijest</strong>
      <small class="text-white ml-2">upravo sada</small>
      <button type="button" class="ml-2 mb-1 bg-white btn-close" data-bs-dismiss="toast" aria-label="Close">
      </button>
    </div>
    <div class="toast-body text-black">
      Vozilo je uspješno registrirano
    </div>
</div>
</div>
<script>
    InitDatatableVozila();
 </script>


<?php get_footer();