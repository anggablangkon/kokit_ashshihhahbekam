function copyNoRek(index) {
	let norek = document.getElementById(`norek-${index}`).textContent;
	navigator.clipboard.writeText(norek).then(function() {
		alert('Nomor rekening disalin!');
	}, function(err) {
		alert('Gagal menyalin');
	});
}
	function copyNominal() {
	    const el = document.getElementById("nominal-rupiah");
	    const angka = el.getAttribute("data-rupiah"); // hanya angka mentah
	    navigator.clipboard.writeText(angka).then(function () {
	        alert("Nominal berhasil disalin: " + angka);
	    }, function () {
	        alert("Gagal menyalin nominal.");
	    });
	}