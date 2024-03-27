const datatableCall = (targetId, url, columns) => {
    $(`#${targetId}`).DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: url,
            type: "GET",
            data: function (d) {
                d.mode = "datatable";
                d.bulan = $("#bulan_filter").val() ?? null;
                d.tahun = $("#tahun_filter").val() ?? null;
                d.tanggal = $("#tanggal_filter").val() ?? null;
            },
        },
        columns: columns,
        lengthMenu: [
            [25, 50, 100, 250, -1],
            [25, 50, 100, 250, "All"],
        ],
    });
};

const ajaxCall = (url, method, data, successCallback, errorCallback) => {
    $.ajax({
        type: method,
        enctype: "multipart/form-data",
        url,
        cache: false,
        data,
        contentType: false,
        processData: false,
        headers: {
            Accept: "application/json",
            "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content"),
        },
        dataType: "json",
        success: function (response) {
            successCallback(response);
        },
        error: function (error) {
            errorCallback(error);
        },
    });
};

const setButtonLoadingState = (buttonSelector, isLoading, title = "Simpan") => {
    const buttonText = isLoading
        ? `<div class="spinner-border spinner-border-sm me-2" role="status">
        </div>
     ${title}`
        : title;
    $(buttonSelector).prop("disabled", isLoading).html(buttonText);
};

const notification = (type, message) => {
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener("mouseenter", Swal.stopTimer);
            toast.addEventListener("mouseleave", Swal.resumeTimer);
        },
    });

    Toast.fire({
        icon: type,
        title: type === "success" ? "Success" : "Error",
        text: message,
    });
};

const getModal = (targetId, url = null, fields = null) => {
    $(`#${targetId}`).modal("show");
    $(`#${targetId} .small`).html("");

    const cekLabelModal = $("#label-modal");
    if (cekLabelModal) {
        $("#id").val("");
        cekLabelModal.text("Tambah");
    }

    if (url) {
        cekLabelModal.text("Edit");

        const successCallback = function (response) {
            fields.forEach((field) => {
                if (response.data[field]) {
                    $(`#${targetId} #${field}`).val(response.data[field]);
                }
            });
        };

        const errorCallback = function (error) {
            console.log(error);
        };

        ajaxCall(url, "GET", null, successCallback, errorCallback);
    }
    $(`#${targetId} .form-control`).val("");
};

const handleValidationErrors = (error, formId = null, fields = null) => {
    if (error.responseJSON.data && fields) {
        fields.forEach((field) => {
            if (error.responseJSON.data[field]) {
                $(`#${formId} #error${field}`).html(
                    error.responseJSON.data[field][0]
                );
            } else {
                $(`#${formId} #error${field}`).html("");
            }
        });
    } else {
        notification("error", error.responseJSON.message);
    }
};

const handleSuccess = (
    response,
    dataTableId = null,
    modalId = null,
    redirect = null
) => {
    if (dataTableId !== null) {
        notification("success", response.message);
        $(`#${dataTableId}`).DataTable().ajax.reload();
    }

    if (modalId !== null) {
        $(`#${modalId}`).modal("hide");
    }

    if (redirect !== null) {
        if (redirect === "no") {
            notification("success", response.message ?? response);
        } else {
            notification("success", response.message ?? response);
            setTimeout(() => {
                window.location.href = redirect;
            }, 1500);
        }
    }
};

const confirmDelete = (url, tableId) => {
    Swal.fire({
        title: "Apakah Kamu Yakin?",
        text: "Ingin menghapus data ini!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, hapus!",
    }).then((result) => {
        if (result.isConfirmed) {
            const data = null;

            const successCallback = function (response) {
                handleSuccess(response, tableId, null);
            };

            const errorCallback = function (error) {
                console.log(error);
            };

            ajaxCall(url, "DELETE", data, successCallback, errorCallback);
        }
    });
};

const select2ToJson = (selector, url) => {
    const selectElem = $(selector);

    if (selectElem.children().length > 0) {
        return;
    }

    const successCallback = function (response) {
        selectElem.append(
            $("<option>", { value: "", text: "-- Pilih Data --" })
        );

        response.data.forEach(function (row) {
            const option = $("<option>", { value: row.id, text: row.nama });
            selectElem.append(option);
        });

        selectElem.select2({
            theme: "bootstrap-5",
            width: "100%",
            dropdownParent: $("#createModal"),
        });
    };

    const errorCallback = function (error) {
        console.error(error);
    };

    ajaxCall(url, "GET", null, successCallback, errorCallback);
};

const formatRupiah = (angka) => {
    var reverse = angka.toString().split("").reverse().join(""),
        ribuan = reverse.match(/\d{1,3}/g);
    ribuan = ribuan.join(".").split("").reverse().join("");
    return "Rp " + ribuan;
};

const reloadData = (type) => {
    let url = null;
    if (type == "keuangan_user") {
        url =
            "/keuangan?bulan=" +
            $("#bulan_filter").val() +
            "&tahun=" +
            $("#tahun_filter").val();
    } else if (type == "keuangan") {
        url =
            "/admin/keuangan?bulan=" +
            $("#bulan_filter").val() +
            "&tahun=" +
            $("#tahun_filter").val();
    } else if (type == "dashboard_user") {
        url =
            "/?bulan=" +
            $("#bulan_filter").val() +
            "&tahun=" +
            $("#tahun_filter").val();
    } else if (type == "dashboard") {
        url =
            "/admin?bulan=" +
            $("#bulan_filter").val() +
            "&tahun=" +
            $("#tahun_filter").val();
    }

    const successCallback = function (response) {
        if (type == "keuangan_user") {
            $("#keuntungan").html(formatRupiah(response.data.keuntungan));
            $("#insentif").html(formatRupiah(response.data.insentif));
            $("#setor").html(formatRupiah(response.data.setoran));
            $("#qty").html(response.data.qty);
        } else if (type == "keuangan") {
            $("#keuntungan").html(formatRupiah(response.data.keuntungan));
            $("#insentif").html(formatRupiah(response.data.insentif));
            $("#setor").html(formatRupiah(response.data.setoran));
            $("#qty").html(response.data.qty);
        } else if (type == "dashboard_user") {
            $("#keuntungan").html(formatRupiah(response.data.keuntungan));
            $("#setor").html(formatRupiah(response.data.setoran));
            $("#qty").html(response.data.qty);
            renderChart(response.data.chart.labels, response.data.chart.qty);
        } else if (type == "dashboard") {
            $("#keuntungan").html(formatRupiah(response.data.keuntungan));
            $("#setor").html(formatRupiah(response.data.setoran));
            $("#qty").html(response.data.qty);
            renderChart(response.data.chart.labels, response.data.chart.qty);
        }
    };

    const errorCallback = function (error) {
        console.log(error);
    };

    ajaxCall(url, "GET", null, successCallback, errorCallback);
};

const resetChart = () => {
    const chartElement = document.querySelector("#chart");
    if (chartElement) {
        chartElement.innerHTML = "";
    }
};

const renderChart = (labels, qty) => {
    resetChart();

    const options = {
        chart: {
            type: "bar",
            height: 400,
        },
        series: [
            {
                name: "Qty",
                data: qty,
            },
        ],
        xaxis: {
            categories: labels,
        },
        title: {
            text: "Grafik Stok Bulan Ini",
        },
    };

    const chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
};
