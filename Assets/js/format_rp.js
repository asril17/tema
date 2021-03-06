function format_rp(angka) {
	var rupiah = '';
	var angkarev = angka.toString().split('').reverse().join('');
	for (var i = 0; i < angkarev.length; i++) if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
	return 'Rp ' + rupiah.split('', rupiah.length - 1).reverse().join('');
}
/**
 * Usage example:
 * alert(convertToRupiah(10000000)); -> "Rp. 10.000.000"
 */

function format_angka(rupiah) {
	return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10) * 1;
}

function custom_notification(style, message = 'Berhasil') {
	$(".cusnot").remove();
	var notif = '';
	notif += '<div class="alert alert-' + style + ' alert-dismissible cusnot" id="cusnot">';
	notif += '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
	notif += message;
	notif += '</div>';
	$("#notif-row").append(notif);
	$(".cusnot").fadeTo(2000, 200).slideUp(200, function () {
		$(".cusnot").slideUp(200);
	});
}
function spinner() {
	return '<center id="spinner"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></center>';
}
function removeSpinner() {
	$("#spinner").remove();
}
$(document).ready(function () {
	$(".rupiah").keyup(function () {
		value = this.value;
		angka = format_angka(value);
		if (isNaN(angka)) {
			this.value = '';
		} else {
			rupiah = format_rp(angka);
			this.value = rupiah;
		}


	})
})