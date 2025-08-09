var nominal = document.getElementById('nominal');
nominal.addEventListener('keyup', function(e){
	nominal.value = formatnominal(this.value, 'Rp. ');
});

		/* Fungsi formatnominal */
function formatnominal(angka, prefix){
	var number_string = angka.replace(/[^,\d]/g, '').toString(),
	split   		= number_string.split(','),
	sisa     		= split[0].length % 3,
	nominal     		= split[0].substr(0, sisa),
	ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
	if(ribuan){
		separator = sisa ? '.' : '';
		nominal += separator + ribuan.join('.');
	}
	nominal = split[1] != undefined ? nominal + ',' + split[1] : nominal;
	return prefix == undefined ? nominal : (nominal ? 'Rp. ' + nominal : '');
}

function prosesPembayaran() {
  const tombol = document.getElementById('pembayaran');
  // Disable tombol dan ubah teks
  tombol.disabled = true;
  tombol.innerText = 'Memproses...';
}

document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('formKontributor');

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(form);

        fetch("kontributor/store", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            body: formData
        })
        .then(response => {
            if (!response.ok) throw response;
            return response.json(); // jika controller return JSON
        })
        .then(data => {
            document.getElementById('alert-success').style.display = 'block';
            document.getElementById('alert-error').style.display = 'none';
            form.reset();
            prosesPembayaran();
            // Redirect jika sukses
            window.location.href = data.redirect;
        })
        .catch(async error => {
            let errorText = '';
            if (error.json) {
                const errData = await error.json();
                for (let field in errData.errors) {
                    errorText += `${errData.errors[field].join(', ')}\n`;
                }
            } else {
                errorText = 'Terjadi kesalahan saat mengirim data.';
            }
            document.getElementById('alert-error').innerText = errorText;
            document.getElementById('alert-error').style.display = 'block';
        });
    });
});
