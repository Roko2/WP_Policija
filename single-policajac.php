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
            <h1>'; echo the_title(); echo'</h1>
            <span class="subheading"></span>
            </div>
        </div>
        </div>
    </div>
    </header>';

echo DajSinglePolicajca(get_the_ID());
?>
<div class="modal fade" id="modalUsavrsavanje" tabindex="-1" role="dialog" aria-labelledby="modalUsavrsavanje" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content text-black">
      <div class="modal-header">
        <h5 class="modal-title">Seminarsko usavršavanje policajca</h5>
          <span aria-hidden="true" class="btn btn-sm btn-danger" data-bs-dismiss="modal"><i class="fa fa-window-close"></i></span>
      </div>
      <div class="modal-body">
      <form id="formUsavrsi" method="POST">
  <div class="form-group">
    <label for="datumUsavrsavanja">Datum usavršavanja</label>
    <small class="form-text text-danger">*</small>
    <input type="date" value="today" class="form-control" name="datumUsavrsavanja" id="datumUsavrsavanja">
  </div>
  <div class="form-group">
    <label for="temaSeminara">Tema seminara</label>
    <small class="form-text text-danger">*</small>
    <input type="text" class="form-control" name="temaSeminara" id="temaSeminara" placeholder="Tema">
  </div>
  <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Odustani</button>
        <button type="button" id="btnUsavrsiPolicajca" disabled class="btn btn-primary" onclick="ModalUsavrsiPolicajca()">Usavrši policajca</button>
        </div>
    </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalPotvrdaUsavrsi" tabindex="-1" role="dialog" aria-labelledby="modalPotvrdaUsavrsi" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content text-black">
      <div class="modal-header">
        <h5 class="modal-title" id="modalPotvrdaUsavrsi">Stručno usavršavanje policajca</h5>
          <span aria-hidden="true" class="btn btn-sm btn-danger" data-bs-dismiss="modal"><i class="fa fa-window-close"></i></span>
      </div>
      <div class="modal-body">
        Jeste li sigurni da želite stručno usavršiti policajca <b id="usavrsiPolicajacTxt"></b>?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Odustani</button>
        <button type="button" class="btn btn-primary" onclick="UsavrsiPolicajca('<?php echo get_the_ID(); ?>')" >Unaprijedi</button>
      </div>
    </div>
  </div>
</div>

<script>
  Date.prototype.toDateInputValue = (function() {
    var local = new Date(this);
    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
    return local.toJSON().slice(0,10);
});
function ModalUsavrsiPolicajca(){
  $("#usavrsiPolicajacTxt").empty();
  $("#usavrsiPolicajacTxt").append('<?php echo get_the_title() ?>');
  $("#modalPotvrdaUsavrsi").modal("show");
}
$(document).ready(function() {
    $('#datumUsavrsavanja').val(new Date().toDateInputValue());
    $("#temaSeminara").on("input",function(){
        if($("#temaSeminara").val()==""){
            $("#btnUsavrsiPolicajca").prop("disabled",true);
        }
        else{
          $("#btnUsavrsiPolicajca").prop("disabled",false);          
        }
    });
  });

  function UsavrsiPolicajca(idPolicajca){
    var id=`${$("#formUsavrsi").serialize()}&idPolicajca=${idPolicajca}&action=usavrsiPolicajca`;
    $.ajax({
      url:'http://localhost/wordpress/wp-admin/admin-ajax.php',
      type:'post',
      data:id,
      success:function(data){
        location.reload();
      }
    })
    }
</script>
<?php get_footer(); 
?>