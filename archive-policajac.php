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
            <h1>Policajci</h1>
            <span class="subheading"></span>
            </div>
        </div>
        </div>
    </div>
    </header>';
    
    DajSvePolicajce();
    get_footer();
    $vrsteSluzbi= get_terms( array(
      'taxonomy' => 'vrstaSluzbe',
      'hide_empty' => false,
    ) );
?>

<div class="modal fade" id="modalUnaprijedi" tabindex="-1" role="dialog" aria-labelledby="modalUnaprijedi" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
	  <div class="modal-content text-black">
		<div class="modal-header">
		  <h5 class="modal-title">Unaprijeđivanje policajca</h5>
			<span aria-hidden="true" class="btn btn-sm btn-danger" data-bs-dismiss="modal"><i class="fa fa-window-close"></i></span>
		</div>
		<div class="modal-body">
		<form id="formUnaprijedi" action="<?php echo site_url() ?>/wp-admin/admin-ajax.php" method="POST">
    <input id="idPolicajca" value="" hidden>
    <select class="form-select" id="vrstaSluzbeSelect">
      <?php
        echo '<option value="" selected>Odaberite</option>';
        foreach($vrsteSluzbi as $x){
       echo '<option value="'.$x->term_id.'">'.$x->name.'</option>'; 
        }
       ?>
    </select>
	  </form>
	<div class="modal-footer">
		  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Odustani</button>
		  <button id="policajacUnaprijedi" type="button" class="btn btn-primary" onclick="ModalUnaprijediPolicajca()" disabled>Unaprijedi policajca</button>
		  </div>
		</div>
	  </div>
	</div>
  </div>

  <div class="modal fade" id="modalPotvrdaUnaprijedi" tabindex="-1" role="dialog" aria-labelledby="modalPotvrdaUnaprijedi" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content text-black">
      <div class="modal-header">
        <h5 class="modal-title" id="modalPotvrdaUnaprijedi">Unaprijeđivanje policajca</h5>
          <span aria-hidden="true" class="btn btn-sm btn-danger" data-bs-dismiss="modal"><i class="fa fa-window-close"></i></span>
      </div>
      <div class="modal-body">
        Jeste li sigurni da želite unaprijediti policajca <b id="policajac"></b> u čin <b id="cin"></b>?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Odustani</button>
        <button type="button" class="btn btn-primary" onclick="UnaprijediPolicajca()" >Unaprijedi</button>
      </div>
    </div>
  </div>
</div>
<div id="tost" class="position-fixed bottom-0 right-0 p-3" aria-live="polite" aria-atomic="true">
  <div id="tostPolicajac" class="toast" data-animation="true" data-delay="2000">
    <div class="toast-header bg-primary text-white">
      <span><i class="fa fa-check" aria-hidden="true"></i></span>
      <strong class="me-auto ml-1">Obavijest</strong>
      <small class="text-white ml-2">upravo sada</small>
      <button type="button" class="ml-2 mb-1 bg-white btn-close" data-bs-dismiss="toast" aria-label="Close">
      </button>
    </div>
    <div class="toast-body text-black">
      Policajac je uspješno unaprijeđen
    </div>
</div>
</div>
<script>
$(window).on('shown.bs.modal', function() { 
  $("#vrstaSluzbeSelect").on("change",function(){
    if($("#vrstaSluzbeSelect option:selected").val()!=""){
      var trenutniId=$("#vrstaSluzbeSelect").val();
      var idVrstaSluzbeJson=`idVrstaSluzbe=${trenutniId}&action=selectCinovi`;
      $.ajax({
        type: "post",
        url: 'http://localhost/wordpress/wp-admin/admin-ajax.php',
        data: idVrstaSluzbeJson,
        success: function(data){
            if($('#formUnaprijedi #selectCinovi').length>0){
                $('#formUnaprijedi #selectCinovi').remove();
            }
            $("#formUnaprijedi").append(data);
            $("#selectCinovi").on("change",function(){
              if($("#selectCinovi option:selected").val()!="" && $("#vrstaSluzbeSelect option:selected").val()!=""){
             $("#policajacUnaprijedi").prop('disabled',false);
            }
            else{
              $("#policajacUnaprijedi").prop('disabled',true);
            }
        });
      }
    }); 
  }
  else{
    $("#policajacUnaprijedi").prop('disabled',true);
  }
  });
});
</script>

