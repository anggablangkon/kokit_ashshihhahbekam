if (jQuery().daterangepicker) {
	let start = moment().subtract(29, "days"),
	end = moment();

	let rangeOptions = {
		startDate: start,
		endDate: end,
		ranges: {
			"Today": [moment(), moment()],
			"Yesterday": [moment().subtract(1, "days"), moment().subtract(1, "days")],
			"Last 7 Days": [moment().subtract(6, "days"), moment()],
			"Last 30 Days": [moment().subtract(29, "days"), moment()],
			"This Month": [moment().startOf("month"), moment().endOf("month")],
			"Last Month": [
				moment().subtract(1, "month").startOf("month"),
				moment().subtract(1, "month").endOf("month")
			]
		},
		locale: {
			format: "MM/DD/YYYY"
		},
		cancelClass: "btn-light",
		applyButtonClasses: "btn-success"
	};

    // Date range picker
	$('[data-toggle="date-picker-range"]').each(function () {
		let $this = $(this),
		dataOptions = $this.data(),
		options = $.extend(true, {}, rangeOptions, dataOptions);

		let displayTarget = $this.attr("data-target-display");

		$this.daterangepicker(options, function (start, end) {
			if (displayTarget) {
				$(displayTarget).html(
					start.format("MMMM D, YYYY") + " - " + end.format("MMMM D, YYYY")
					);
			}
		});

		if (displayTarget) {
			$(displayTarget).html(
				start.format("MMMM D, YYYY") + " - " + end.format("MMMM D, YYYY")
				);
		}
	});

    // Single date picker tgl bulan dan tahun
	let singleDateOptions = {
		singleDatePicker: true,
		showDropdowns: true,
		locale: {
			format: "MM/DD/YYYY"
		},
		cancelClass: "btn-light",
		applyButtonClasses: "btn-success"
	};

	$('[data-toggle="date-picker"]').each(function () {
		let $this = $(this),
		dataOptions = $this.data(),
		options = $.extend(true, {}, singleDateOptions, dataOptions);

		if (typeof options.locale === "string") {
			try {
				options.locale = JSON.parse(options.locale.replace(/'/g, '"'));
			} catch (error) {
				console.warn("Invalid JSON format in data-locale:", error);
			}
		}

		$this.daterangepicker(options);
	});

    $(function(){
	const $input = $('#monthYearPicker');

	$input.daterangepicker({
		singleDatePicker: true,
		showDropdowns: false, // kita buat sendiri
		autoUpdateInput: false,
		locale: { format: 'MM/YYYY' }
	});

	$input.on('show.daterangepicker', function(ev, picker) {
		// Hapus kalender bawaan
		picker.container.find('.drp-calendar').remove();

		// Hapus dropdown lama
		picker.container.find('.month-year-select-wrap').remove();

		// Bungkus dropdown custom
		const $wrap = $('<div class="month-year-select-wrap p-3"></div>');
		const $monthSelect = $('<select class="form-select d-inline w-auto me-2"></select>');
		const $yearSelect = $('<select class="form-select d-inline w-auto"></select>');

		// Isi bulan
		for (let m = 0; m < 12; m++) {
			$monthSelect.append(`<option value="${m}">${moment().month(m).format('MMMM')}</option>`);
		}

		// Isi tahun
		const currentYear = moment().year();
		for (let y = currentYear - 5; y <= currentYear + 5; y++) {
			$yearSelect.append(`<option value="${y}">${y}</option>`);
		}

		// Gabungkan ke wrapper
		$wrap.append($monthSelect).append($yearSelect);
		picker.container.prepend($wrap);

		// Set default ke tanggal awal datepicker
		$monthSelect.val(picker.startDate.month());
		$yearSelect.val(picker.startDate.year());

		// Update saat berubah
		function updateDate() {
			const newDate = moment([$yearSelect.val(), $monthSelect.val(), 1]);
			$input.val(newDate.format('MM/YYYY'));
			picker.setStartDate(newDate);
		}

		$monthSelect.on('change', updateDate);
		$yearSelect.on('change', updateDate);
	});

	// Saat klik Apply
	$input.on('apply.daterangepicker', function(ev, picker) {
		$input.val(picker.startDate.format('MM/YYYY'));
	});
});



}
