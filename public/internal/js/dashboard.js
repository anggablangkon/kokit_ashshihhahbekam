const searchInput = document.getElementById("searchInput");
let debounceTimeout;

searchInput.addEventListener("input", () => {
  clearTimeout(debounceTimeout);
  debounceTimeout = setTimeout(() => {
      const keyword = searchInput.value.trim();
      loadTableData(1, keyword); 
  }, 300); 
});

// load awal
loadChartData(); 

document.addEventListener("DOMContentLoaded", () => {
  loadTableData(); // pertama kali tanpa keyword
});



function loadTableData(page = 1, keyword = '') {

  const loading = document.getElementById("loadingIndicator");
  loading.style.display = "block"; // show loading

  fetch(`/produk/ajax-load?page=${page}&keyword=${keyword}`)
      .then(response => response.json())
      .then(data => {
          // Isi tbody
          document.getElementById("topperproduk").innerHTML = data.html;

          // Isi info pagination
          const info = document.querySelector('[data-table-pagination-info="data"]');
          info.innerText = `Menampilkan ${data.pagination.from} - ${data.pagination.to} dari ${data.pagination.total} data`;

          // Buat tombol pagination
          const pagination = document.querySelector('[data-table-pagination]');
          pagination.innerHTML = '';

          for (let i = 1; i <= data.pagination.last_page; i++) {
              const btn = document.createElement("button");
              btn.className = "btn btn-sm mx-1 " + (i === data.pagination.current_page ? "btn-primary" : "btn-outline-primary");
              btn.innerText = i;
              btn.onclick = () => loadTableData(i, keyword);
              pagination.appendChild(btn);
          }
      }).finally(() => {
        loading.style.display = "none"; // hide loading after finished
      });
}


function ajaxGetSummaryData(keyword = "") {

  let url = "/produk/chart-summary";
  fetch(url)
      .then((response) => {
          if (!response.ok) throw new Error("Network response was not ok");
          return response.text();
      })
      .then((data) => {
          document.getElementById("SummaryData").innerHTML = data;
      })
      .catch((error) => {
          console.error("Fetch error:", error);
      })
      .finally(() => {
      });
}

function tambahKedatangan(iteration) {
    const modalElement = document.getElementById("tambahKedatanganModal");
    const bootstrapModal = new bootstrap.Modal(modalElement);
    const token = document.getElementById("Modal" + iteration).getAttribute("data-token");
    const sisa = document.getElementById("Modal" + iteration).getAttribute("data-sisa");

    let url = "/produk/ajax-klien/" + token;

    fetch(url)
        .then((response) => {
            if (!response.ok) throw new Error("Network response was not ok");
            return response.json();
        })
        .then((data) => {
            if (data.success && data.data) {
                document.getElementById("nopo").value = data.data.no_po;
                document.getElementById("nama").value = data.data.nama_klien;
                document.getElementById("token").value = token;
                document.getElementById("qtykedatangan").setAttribute("data-sisa", sisa);
                document.getElementById("qtykedatangan").setAttribute("max", sisa);
                document.getElementById("qtykedatangan").value = '';
                document.getElementById("keterangan").value = '';
                document.getElementById("qtykedatangan").focus();
                bootstrapModal.show();
            } else {
                console.error("Data tidak ditemukan atau token invalid");
            }
        })
        .catch((error) => {
            console.error("Fetch error:", error);
        });
}

// submit
document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('formKedatangan');
  const modalElement = document.getElementById('tambahKedatanganModal');
  const bootstrapModal = new bootstrap.Modal(modalElement);

  form.addEventListener('submit', function(e) {
    e.preventDefault(); // cegah reload

    // ambil data form dengan FormData
    const formData = new FormData(form);
    // Pastikan qty tanpa titik dan karakter non-angka
    if (qtyInput) {
      formData.set('qty', qtyInput.value.replace(/\./g, '').replace(/[^0-9]/g, ''));
    }
    // Parsing qty dan sisa dengan aman
    const qty = parseInt(qtyInput.value.replace(/\./g, '').replace(/[^0-9]/g, ''));
    const sisaRaw = qtyInput.getAttribute("data-sisa");
    const sisa = parseInt((sisaRaw ? sisaRaw : '').replace(/\./g, '').replace(/[^0-9]/g, ''));
    console.log('qty:', qty, 'sisa:', sisa, 'raw qty:', qtyInput.value, 'raw sisa:', sisaRaw);
    if (isNaN(qty) || isNaN(sisa)) {
        Swal.fire('Error', 'Qty atau sisa tidak valid!', 'error');
        return;
    }
    if (qty > sisa) {
        Swal.fire('Error', 'Qty tidak boleh lebih dari sisa (' + sisa + ')', 'error');
        return;
    }
    if (qty < 1) {
        Swal.fire('Error', 'Qty minimal 1', 'error');
        return;
    }
    fetch(form.action, {
      method: 'POST',
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
        // csrf token bisa juga lewat meta tag (Laravel biasanya sudah ada <meta name="csrf-token" content="...">)
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: formData,
    })
    .then(response => {
      if (!response.ok) throw new Error('Network response was not ok');
      return response.json();  // asumsikan respon json
    })
    .then(data => {
      if(data.success) {
        Swal.fire({
          icon: 'success',
          title: 'Berhasil!',
          text: 'Data berhasil disimpan!',
          timer: 1500,
          showConfirmButton: false
        });
        // Tutup modal tambah data
        var tambahDataModal = document.getElementById('tambahKedatanganModal');
        if (tambahDataModal) {
            bootstrap.Modal.getInstance(tambahDataModal).hide();
        }
        qtyInput.value = 0;
        document.getElementById("keterangan").value = "";
        ajaxGetHardcoded();
        loadChartData(); 
      } else {
        alert('Gagal menyimpan: ' + (data.message || 'Unknown error'));
      }
    })
    .catch(error => {
      console.error('Fetch error:', error);
      alert('Terjadi kesalahan saat menyimpan data.');
    });
  });
});


function loadChartData() {
  fetch("/produk/chart-data")
    .then(response => {
      if (!response.ok) throw new Error("Gagal ambil data");
      return response.json();
    })
    .then(data => {
      renderChart(data); // ✅ Panggil fungsi render setelah data siap
    })
    .catch(error => {
      console.error("Error ambil data chart:", error);
    });
}

function renderChart(produkData) {
  // Fungsi untuk format angka dengan desimal
  function formatDecimal(number) {
    return new Intl.NumberFormat('id-ID', {
      minimumFractionDigits: 0,
      maximumFractionDigits: 0
    }).format(number);
  }

  new CustomEChart({
    selector: "#orders-chart",
    options: () => ({
      tooltip: {
        trigger: "axis",
        axisPointer: { type: "shadow" },
        formatter: (params) => {
          let res = `<strong>${params[0].axisValue}</strong><br/>`;
          params.forEach((p) => {
            // Format desimal untuk semua nilai
            const formattedValue = formatDecimal(p.data, 2);
            res += `${p.marker} ${p.seriesName}: <strong>${formattedValue}</strong><br/>`;
          });
          return res;
        },
      },
      legend: {
        data: ["Harus Dipenuhi", "Terpenuhi", "Sisa"],
        top: 15,
        textStyle: { color: ins("body-color") },
      },
      xAxis: {
        type: "category",
        data: produkData.map(p => p.kode),
        axisLine: { lineStyle: { color: ins("border-color") } },
        axisLabel: { color: ins("dark") },
      },
      yAxis: {
        type: "value",
        axisLine: { lineStyle: { color: ins("border-color") } },
        axisLabel: { 
          color: ins("dark"),
          formatter: function(value) {
            return formatDecimal(value, 2);
          }
        },
      },
      grid: {
        left: 25,
        right: 25,
        bottom: 25,
        top: 60,
        containLabel: true
      },
      series: [
        {
          name: "Harus Dipenuhi",
          type: "line",
          smooth: true,
          itemStyle: { color: ins("success") },
          data: produkData.map(p => parseFloat(p.total_qty).toFixed(2)), // Format desimal untuk Harus Dipenuhi
          symbol: 'circle',
          symbolSize: 6,
          lineStyle: {
            width: 0
          },
        },
        {
          name: "Terpenuhi",
          type: "bar",
          barWidth: 20,
          itemStyle: { color: ins("success") },
          data: produkData.map(p => parseFloat(p.qty).toFixed(2)), // Format desimal untuk Terpenuhi
        },
        {
          name: "Sisa",
          type: "bar",
          barWidth: 20,
          itemStyle: { color: ins("danger") },
          data: produkData.map(p => parseFloat(p.kedatangan).toFixed(2)), // Format desimal untuk Sisa
        },
      ],
    }),
  });
}


