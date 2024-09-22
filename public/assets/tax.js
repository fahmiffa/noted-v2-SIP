const indeks = {
  fungsi: [{
          name: "Hunian (< 100 m2 dan < 2 lantai)",
          index: "0.15",
          ilo: "0.4"
      },
      {
          name: "Hunian (> 100 m2 dan > 2 lantai)",
          index: "0.17",
          ilo: "0.4"
      },
      {
          name: "Keagamaan",
          index: "0",
          ilo: "0.4"
      },
      {
          name: "Usaha",
          index: "0.7",
          ilo: "0.4"
      },
      {
          name: "Usaha UMKM",
          index: "0.5",
          ilo: "0.4"
      },
      {
          name: "Sosial Budaya (Nirlaba/Non-Profit)",
          index: "0.3",
          ilo: "0.2"
      },
      {
          name: "Sosial Budaya",
          index: "0.3",
          ilo: "0.4"
      },
      {
          name: "Fungsi Khusus",
          index: "1",
          ilo: "0.4"
      },
      {
          name: "Campuran < 500 m2 dan/atau <2 Lantai",
          index: "0.6",
          ilo: "0.4",
      },
      {
          name: "Campuran > 500 m2 dan/atau >= 2 Lantai",
          index: "0.8",
          ilo: "0.4"
      },
  ],
  kepemilikan: [{
          name: "Perorangan\/Badan Usaha",
          index: "1"
      },
      {
          name: "Negara",
          index: "0"
      },
  ],
  kompleksitas: [{
          name: "Sederhana",
          index: "1"
      },
      {
          name: "Tidak Sederhana",
          index: "2"
      },
  ],
  permanensi: [{
          name: "Non Permanen",
          index: "1"
      },
      {
          name: "Permanen",
          index: "2"
      },
  ],
  ketinggian: [{
          name: "Tidak Ada",
          index: "0"
      },
      {
          name: "1 Lapis",
          index: "1.197"
      },
      {
          name: "2 Lapis",
          index: "1.299"
      },
      {
          name: "3 Lapis",
          index: "1.393"
      },
      {
          name: "1 Lantai",
          index: "1"
      },
      {
          name: "2 Lantai",
          index: "1.09"
      },
      {
          name: "3 Lantai",
          index: "1.12"
      },
      {
          name: "4 Lantai",
          index: "1.135"
      },
      {
          name: "5 Lantai",
          index: "1.162"
      },
      {
          name: "6 Lantai",
          index: "1.197"
      },
      {
          name: "7 Lantai",
          index: "1.236"
      },
      {
          name: "8 Lantai",
          index: "1.265"
      },
      {
          name: "9 Lantai",
          index: "1.299"
      },
      {
          name: "10 Lantai",
          index: "1.333"
      },
  ],
  kegiatan: [{
          name: "Bangunan Gedung Baru",
          index: "1"
      },
      {
          name: "Rehabilitasi/Renovasi - Sedang",
          index: "0.225"
      },
      {
          name: "Rehabilitasi/Renovasi - Berat",
          index: "0.325"
      },
      {
          name: "Pelestarian/Pemugaran Pratama",
          index: "0.325"
      },
      {
          name: "Pelestarian/Pemugaran - Madya",
          index: "0.225"
      },
      {
          name: "Pelestarian/Pemugaran - Utama",
          index: "0.15"
      },
  ]
};

const prasarana = [{
      nama: "Pagar",
      hargaSatuan: 1500,
      satuan: "m1"
  },
  {
      nama: "Tanggul/retaining wall",
      hargaSatuan: 1400,
      satuan: "m1"
  },
  {
      nama: "Turap batas kavling/persil",
      hargaSatuan: 2500,
      satuan: "m1"
  },
  {
      nama: "Gapura",
      hargaSatuan: 12000,
      satuan: "m2"
  },
  {
      nama: "Gerbang",
      hargaSatuan: 14000,
      satuan: "m2"
  },
  {
      nama: "Jalan/Parkir/Conblock",
      hargaSatuan: 2000,
      satuan: "m2"
  },
  {
      nama: "Lapangan Upacara",
      hargaSatuan: 1500,
      satuan: "m2"
  },
  {
      nama: "Lapangan Olahraga Terbuka",
      hargaSatuan: 3000,
      satuan: "m2"
  },
  {
      nama: "Konstruksi perkerasan aspal / beton",
      hargaSatuan: 6000,
      satuan: "m2"
  },
  {
      nama: "Konstruksi perkerasan grassblock",
      hargaSatuan: 5000,
      satuan: "m2"
  },
  {
      nama: "Jembatan",
      hargaSatuan: 6000,
      satuan: "m2"
  },
  {
      nama: "Box culvert",
      hargaSatuan: 6000,
      satuan: "m2"
  },
  {
      nama: "Jembatan Antar Gedung",
      hargaSatuan: 50000,
      satuan: "m2"
  },
  {
      nama: "Jembatan Penyeberangan Orang/Barang",
      hargaSatuan: 300000,
      satuan: "m2"
  },
  {
      nama: "Jembatan Bawah Tanah / Underpass",
      hargaSatuan: 200000,
      satuan: "m2"
  },
  {
      nama: "Konstruksi Kolam Renang",
      hargaSatuan: 25000,
      satuan: "m2"
  },
  {
      nama: "Kolam Reservoir Bawah Tanah",
      hargaSatuan: 20000,
      satuan: "m2"
  },
  {
      nama: "Konstruksi septic tank / sumur resapan",
      hargaSatuan: 150000,
      satuan: "m2"
  },
  {
      nama: "Kontruksi Menara Reservoir (per 5 m2)",
      hargaSatuan: 50000,
      satuan: "Unit"
  },
  {
      nama: "Konstruksi Menara Cerobong (per 5 m2)",
      hargaSatuan: 180000,
      satuan: "Unit"
  },
  {
      nama: "Konstruksi Menara Air (per 5 m2)",
      hargaSatuan: 500000,
      satuan: "Unit"
  },
  {
      nama: "Konstruksi Monumen Tugu",
      hargaSatuan: 1000000,
      satuan: "Unit"
  },
  {
      nama: "Konstruksi Monumen Patung",
      hargaSatuan: 100000,
      satuan: "Unit"
  },
  {
      nama: "Monumen di Dalam Persil",
      hargaSatuan: 500000,
      satuan: "Unit"
  },
  {
      nama: "Monumen di Luar Persil (Nilai RAB Fisik)",
      hargaSatuan: 1.75,
      satuan: "Rp"
  },
  {
      nama: "Instalasi Listrik (maks. 10 m2)",
      hargaSatuan: 650000,
      satuan: "Unit"
  },
  {
      nama: "Instalasi Listrik (tambahan > 10 m2)",
      hargaSatuan: 6500,
      satuan: "m2"
  },
  {
      nama: "Instalasi Telepon (maks. 10 m2)",
      hargaSatuan: 500000,
      satuan: "Unit"
  },
  {
      nama: "Instalasi Telepon (tambahan > 10 m2)",
      hargaSatuan: 5000,
      satuan: "m2"
  },
  {
      nama: "Instalasi Pengolahan (maks. 10 m2)",
      hargaSatuan: 500000,
      satuan: "Unit"
  },
  {
      nama: "Instalasi Pengolahan (tambahan > 10 m2)",
      hargaSatuan: 5000,
      satuan: "m2"
  },
  {
      nama: "Reklame/Papan nama (maks. 30 m2)",
      hargaSatuan: 7000000,
      satuan: "Unit"
  },
  {
      nama: "Reklame/Papan nama (tambahan > 30 m2)",
      hargaSatuan: 500000,
      satuan: "m2"
  },
  {
      nama: "Konstruksi Pondasi Mesin",
      hargaSatuan: 500000,
      satuan: "Unit"
  },
  {
      nama: "Konstruksi Menara Televisi (maks. 100 m)",
      hargaSatuan: 75000000,
      satuan: "Unit"
  },
  {
      nama: "Antena Radio Standing 25-50 m",
      hargaSatuan: 5000000,
      satuan: "Unit"
  },
  {
      nama: "Antena Radio Standing 51-75 m",
      hargaSatuan: 7500000,
      satuan: "Unit"
  },
  {
      nama: "Antena Radio Standing 76-100 m",
      hargaSatuan: 10000000,
      satuan: "Unit"
  },
  {
      nama: "Antena Radio Standing 101-125 m",
      hargaSatuan: 12500000,
      satuan: "Unit"
  },
  {
      nama: "Antena Radio Standing 126-150 m",
      hargaSatuan: 15000000,
      satuan: "Unit"
  },
  {
      nama: "Antena Radio Standing > 150 m",
      hargaSatuan: 25000000,
      satuan: "Unit"
  },
  {
      nama: "Antena Radio Guywire 0-50 m",
      hargaSatuan: 2500000,
      satuan: "Unit"
  },
  {
      nama: "Antena Radio Guywire 51-75 m",
      hargaSatuan: 4000000,
      satuan: "Unit"
  },
  {
      nama: "Antena Radio Guywire 76-100 m",
      hargaSatuan: 5000000,
      satuan: "Unit"
  },
  {
      nama: "Antena Radio Guywire > 100 m",
      hargaSatuan: 10000000,
      satuan: "Unit"
  },
  {
      nama: "Tower Telekomunikasi Bersama < 25 m",
      hargaSatuan: 25000000,
      satuan: "Unit"
  },
  {
      nama: "Tower Telekomunikasi Bersama 25 - 50 m",
      hargaSatuan: 45000000,
      satuan: "Unit"
  },
  {
      nama: "Tower Telekomunikasi Bersama > 50 m",
      hargaSatuan: 60000000,
      satuan: "Unit"
  },
  {
      nama: "Tower Telekomunikasi Mandiri < 25 m",
      hargaSatuan: 35000000,
      satuan: "Unit"
  },
  {
      nama: "Tower Telekomunikasi Mandiri 25 - 50 m",
      hargaSatuan: 75000000,
      satuan: "Unit"
  },
  {
      nama: "Tower Telekomunikasi Mandiri > 50 m",
      hargaSatuan: 125000000,
      satuan: "Unit"
  },
  {
      nama: "Tangki Tanam Bahan Bakar",
      hargaSatuan: 10000000,
      satuan: "Unit"
  },
  {
      nama: "Pekerjaan Drainase (dalam persil)",
      hargaSatuan: 1000,
      satuan: "m1"
  },
  {
      nama: "Konstruksi Penyimpanan / Silo",
      hargaSatuan: 1000,
      satuan: "m2"
  }
];     

$(document).ready(function () {
  $.each(indeks.fungsi, function (index, value) {
    $("#if").append(
      $("<option>", {
        value: value.index,
        text: value.name,
      })
    );
  });

  $.each(indeks.kompleksitas, function (index, value) {
    $("#ik").append(
      $("<option>", {
        value: value.index * settings.kompleksitas,
        text: value.name,
      })
    );
  });

  $.each(indeks.permanensi, function (index, value) {
    $("#ip").append(
      $("<option>", {
        value: value.index * settings.permanensi,
        text: value.name,
      })
    );
  });

  $.each(indeks.ketinggian, function (index, value) {
    $("#il").append(
      $("<option>", {
        value: value.index * settings.ketinggian,
        text: value.name,
      })
    );
  });

  $.each(indeks.kepemilikan, function (index, value) {
    $("#fm").append(
      $("<option>", {
        value: value.index,
        text: value.name,
      })
    );
  });

  $.each(indeks.kegiatan, function (index, value) {
    $("#ibg").append(
      $("<option>", {
        value: value.index,
        text: value.name,
      })
    );
  });

  $.each(prasarana, function (index, value) {
    $(".ur").append(
      $("<option>", {
        value: value.nama,
        text: value.nama,
      })
    );
  });

  let shst = settings.shst.toLocaleString("id-ID");
  $("#shst").val(shst);
});

function pilihNilaine(e) {
  var selected = e.options[e.selectedIndex].value;
  var sel = e.options[e.selectedIndex].text;
  if (sel === "Pilih") {
    $(e).addClass("is-invalid");
    return false;
  } else {
    $(e).removeClass("is-invalid");
    if (e.id == "if") {
      let data = indeks.fungsi;
      let result = data.filter((obj) => obj.name === sel);
      $("#view-ilo").html(result[0].ilo + " %");
      $("#index-ilo").html(result[0].ilo);
      $("#ilo").val(result[0].ilo);
    }
    $("#view-" + e.id).html(selected);
    $("#index-" + e.id).val(selected);
    $("#name-" + e.id).val(sel);
    it();
    sumWide();
  }
}

function pilihUraian(e) {
  let satuan;
  let price;
  let sat;

  var id = $(e).attr("data-id");
  var selected = e.options[e.selectedIndex].value;
  var sel = e.options[e.selectedIndex].text;
  if (sel === "Pilih") {
    $(e).addClass("is-invalid");
    satuan = 0;
    price = 0;
  } else {
    $(e).removeClass("is-invalid");
    let result = prasarana.filter((obj) => obj.nama === sel);

    price = result[0].hargaSatuan;

    if (result[0].satuan === "m1") {
      satuan = "m";
    } else if (result[0].satuan === "m2") {
      satuan = "m<sup>2</sup>";
    } else if (result[0].satuan === "m3") {
      satuan = "m<sup>3</sup>";
    } else if (result[0].satuan === "Rp") {
      price = result[0].hargaSatuan / 100;
      price = price.toFixed(2);
      satuan = result[0].satuan;
    } else {
      satuan = result[0].satuan;
    }

    sat = result[0].satuan;
  }

  $("#view-sat" + id).html(satuan);
  $("#sat" + id).val(sat);

  $("#price" + id).val(price);
  $("#view-price" + id).html(price.toLocaleString("id-ID"));
}

function it() {
  let fi = parseFloat($("#if").val());
  let ik = parseFloat($("#ik").val());
  let ip = parseFloat($("#ip").val());
  let il = parseFloat($("#il").val());
  let fm = parseFloat($("#fm").val());
  let n = 0;
  let mid;
  n = fi * (ik + ip + il) * fm;
  n = Math.ceil(n * 1000) / 1000;
  n = isNaN(n) ? 0 : n;
  $("#it").val(n.toFixed(3));
  $("#view-it").html(n.toFixed(3));
}

$(".select-field").select2({
  theme: "bootstrap-5",
});

function sumWide() {
  let it = parseFloat($("#it").val());
  let ilo = parseFloat($("#ilo").val());
  let ibg = parseFloat($("#ibg").val());
  let shst = parseFloat(settings.shst);
  let llt = 0;
  let retri = 0;
  var inputs = document.querySelectorAll(".float-input");
  inputs.forEach(function (input) {
    llt += parseFloat(input.value);
  });
  $("#llt").val(llt);
  retri = it * ibg * ilo * shst * llt;
  retri = retri.toFixed(0);
  retri = Math.ceil(retri / 100);
  retri = isNaN(retri) ? 0 : retri;
  $("#view-retri").html(retri.toLocaleString("id-ID"));
  $("#retri").val(retri);
}

function praSum(e) {
  let tot = 0;
  var id = $(e).attr("data-id");
  let price = $("#price" + id).val();
  tot = e.value * price;

  $("#sum" + id).val(tot);
  $("#view-sum" + id).html(tot.toLocaleString("id-ID"));

  sumRetri();
}

function sumRetri() {
  let sum = 0;
  let tot = 0;
  var inputs = document.querySelectorAll(".sum");
  inputs.forEach(function (input) {
    sum += parseFloat(input.value);
  });
  console.log(sum);
  $("#sumPra").val(sum);
  $("#view-sumPra").html(sum.toLocaleString("id-ID"));

  let retri = $("#retri").val();
  tot = parseFloat(retri) + parseFloat(sum);
  $("#totRetri").val(tot);
  $("#view-totRetri").html(tot.toLocaleString("id-ID"));
}
