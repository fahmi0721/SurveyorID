// js untuk show hide foto pengawasan harian
$('.prog_i_1tdk').on('click', function() {
    var confir = confirm("Are you sure want to change this access?");
    $('.fot_i_1').hide();
});
$('.prog_i_1ada').on('click', function() {
    $('.fot_i_1').show();
});