<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>
        Nilai Kuliah Lapangan
    </title>


    <!-- Bootstrap 4 -->

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">


    <style>
        body {
            background: #f5f6f8;
        }

        .container-main {
            padding-top: 30px;
            padding-bottom: 50px;
        }

        .card {
            border: none;
            box-shadow:
                0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .card-header {
            background: #fff;
        }

        .table th {
            white-space: nowrap;
            vertical-align: middle;
        }

        .table td {
            vertical-align: middle;
        }

        .table thead th {
            background: #f8f9fa;
        }

        .nilai-final {
            font-size: 16px;
            font-weight: bold;
        }

        .filter-label {
            font-weight: 600;
        }

        .loading-container {
            padding: 40px;
            text-align: center;
        }

        .empty-container {
            padding: 40px;
            text-align: center;
        }

        .copy-success {
            margin-left: 10px;
        }

        @media (max-width: 767px) {

            .container-main {
                padding-top: 15px;
            }

            .table {
                font-size: 13px;
            }

        }
    </style>

</head>


<body>


    <div id="app">


        <div class="container-fluid container-main">


            <!-- ====================================== -->
            <!-- HEADER -->
            <!-- ====================================== -->

            <div class="card mb-4">

                <div class="card-body">

                    <h4 class="mb-1">
                        Nilai Kuliah Lapangan
                    </h4>

                    <small class="text-muted">
                        Kuliah Lapangan ID: 13
                    </small>

                </div>

            </div>



            <!-- ====================================== -->
            <!-- FILTER -->
            <!-- ====================================== -->

            <div class="card mb-4">

                <div class="card-header">

                    <strong>
                        Filter Data
                    </strong>

                </div>


                <div class="card-body">

                    <div class="row">


                        <!-- PRODI -->

                        <div class="col-md-5">

                            <div class="form-group">

                                <label class="filter-label">
                                    Program Studi
                                </label>


                                <select
                                    class="form-control"
                                    v-model="selectedProdi"
                                    :disabled="loadingProdi">

                                    <option value="">
                                        -- Semua Program Studi --
                                    </option>


                                    <option
                                        v-for="prodi in prodis"
                                        :key="prodi.prodi_kode"
                                        :value="prodi.prodi_kode">

                                        @{{ prodi.prodi_kode }}
                                        -
                                        @{{ prodi.prodi_nama }}

                                    </option>

                                </select>

                            </div>

                        </div>



                        <!-- PEMBIMBING -->

                        <div class="col-md-5">

                            <div class="form-group">

                                <label class="filter-label">
                                    Dosen Pembimbing
                                </label>


                                <select
                                    class="form-control"
                                    v-model="selectedPembimbing"
                                    :disabled="loadingPembimbing">

                                    <option value="">
                                        -- Semua Pembimbing --
                                    </option>


                                    <option
                                        v-for="pembimbing in pembimbings"
                                        :key="pembimbing.pembimbing_id"
                                        :value="pembimbing.pembimbing_id">

                                        @{{ pembimbing.nama_lengkap }}

                                    </option>

                                </select>

                            </div>

                        </div>



                        <!-- BUTTON -->

                        <div class="col-md-2">

                            <div
                                class="form-group"
                                style="padding-top: 30px;">

                                <button
                                    type="button"
                                    class="btn btn-primary btn-block"
                                    @click="loadNilai"
                                    :disabled="loadingNilai">

                                    <span v-if="loadingNilai">

                                        <span
                                            class="spinner-border spinner-border-sm mr-1"></span>

                                        Memuat...

                                    </span>


                                    <span v-else>

                                        Tampilkan

                                    </span>

                                </button>

                            </div>

                        </div>


                    </div>


                    <!-- ================================== -->
                    <!-- FILTER AKTIF -->
                    <!-- ================================== -->

                    <div
                        v-if="sudahCari"
                        class="mt-2">

                        <span class="badge badge-info mr-1">

                            Prodi:

                            @{{ selectedProdi || 'Semua' }}

                        </span>


                        <span class="badge badge-info">

                            Pembimbing:

                            @{{ selectedPembimbingNama || 'Semua' }}

                        </span>

                    </div>


                </div>

            </div>



            <!-- ====================================== -->
            <!-- LOADING -->
            <!-- ====================================== -->

            <div
                v-if="loadingNilai"
                class="card mb-4">

                <div class="loading-container">

                    <div
                        class="spinner-border text-primary mb-3"></div>

                    <div>
                        Memuat data nilai mahasiswa...
                    </div>

                </div>

            </div>



            <!-- ====================================== -->
            <!-- HASIL -->
            <!-- ====================================== -->

            <div
                v-if="!loadingNilai && nilai.length > 0"
                class="card mb-4">


                <!-- HEADER TABLE -->

                <div class="card-header">

                    <div
                        class="d-flex justify-content-between align-items-center flex-wrap">

                        <strong>
                            Data Nilai Mahasiswa
                        </strong>


                        <div class="mt-2 mt-md-0">

                            <span class="badge badge-primary mr-2">

                                @{{ nilai.length }}
                                Mahasiswa

                            </span>


                            <!-- COPY -->

                            <button
                                type="button"
                                class="btn btn-success btn-sm"
                                @click="copyTable">

                                📋 Copy Tabel

                            </button>


                            <span
                                v-if="copySuccess"
                                class="text-success copy-success">

                                ✓ Berhasil dicopy

                            </span>

                        </div>

                    </div>

                </div>



                <!-- SEARCH -->

                <div class="card-body border-bottom">

                    <div class="row">

                        <div class="col-md-6">

                            <input
                                type="text"
                                class="form-control"
                                v-model="search"
                                placeholder="Cari NIM atau nama mahasiswa...">

                        </div>

                    </div>

                </div>



                <!-- TABLE -->

                <div class="card-body p-0">

                    <div class="table-responsive">

                        <table
                            class="table table-bordered table-striped table-hover mb-0">

                            <thead>

                                <tr>

                                    <th
                                        width="50"
                                        class="text-center">
                                        No
                                    </th>

                                    <th>
                                        NIM
                                    </th>

                                    <th>
                                        Nama Mahasiswa
                                    </th>

                                    <th>
                                        Program Studi
                                    </th>

                                    <th>
                                        Pembimbing
                                    </th>

                                    <th class="text-center">
                                        Nilai Pembimbing (30%)
                                    </th>

                                    <th class="text-center">
                                        Nilai Pamong (70%)
                                    </th>

                                    <th class="text-center">
                                        Nilai Final
                                    </th>

                                </tr>

                            </thead>


                            <tbody>


                                <tr
                                    v-for="(item, index) in filteredNilai"
                                    :key="item.nim + '-' + index">


                                    <!-- NO -->

                                    <td class="text-center">

                                        @{{ index + 1 }}

                                    </td>



                                    <!-- NIM -->

                                    <td>

                                        <strong>
                                            @{{ item.nim }}
                                        </strong>

                                    </td>



                                    <!-- NAMA -->

                                    <td>

                                        @{{ item.nama_lengkap }}

                                    </td>



                                    <!-- PRODI -->

                                    <td>



                                        @{{ item.prodi_nama }}

                                    </td>



                                    <!-- PEMBIMBING -->

                                    <td>

                                        @{{ item.pembimbing || '-' }}

                                    </td>



                                    <!-- NILAI PEMBIMBING -->

                                    <td class="text-center">

                                        @{{ formatNilai(item.nilai_pembimbing) }}

                                    </td>



                                    <!-- NILAI EKSTERNAL -->

                                    <td class="text-center">

                                        @{{ formatNilai(item.nilai_eksternal) }}

                                    </td>



                                    <!-- NILAI FINAL -->

                                    <td class="text-center">

                                        <span
                                            v-if="item.nilai_final !== null"
                                            class="nilai-final">

                                            @{{ item.nilai_final }}

                                        </span>


                                        <span
                                            v-else
                                            class="text-muted">

                                            -

                                        </span>

                                    </td>


                                </tr>


                            </tbody>

                        </table>

                    </div>

                </div>


            </div>



            <!-- ====================================== -->
            <!-- DATA KOSONG -->
            <!-- ====================================== -->

            <div
                v-if="
                sudahCari &&
                !loadingNilai &&
                nilai.length === 0
            "
                class="card">

                <div class="empty-container">

                    <h5>
                        Data Tidak Ditemukan
                    </h5>

                    <p class="text-muted mb-0">

                        Tidak ditemukan mahasiswa
                        berdasarkan filter yang dipilih.

                    </p>

                </div>

            </div>



            <!-- ====================================== -->
            <!-- BELUM CARI -->
            <!-- ====================================== -->

            <div
                v-if="!sudahCari"
                class="alert alert-secondary">

                Pilih Program Studi atau Dosen Pembimbing
                jika ingin melakukan filter.

                <br>

                <small>
                    Filter dapat digunakan sendiri-sendiri
                    atau dikombinasikan.
                </small>

            </div>


        </div>

    </div>



    <!-- ========================================== -->
    <!-- VUE 2 -->
    <!-- ========================================== -->

    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>


    <!-- ========================================== -->
    <!-- AXIOS -->
    <!-- ========================================== -->

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>



    <script>
        new Vue({

            el: '#app',


            data: {

                // ======================================
                // DATA
                // ======================================

                prodis: [],

                pembimbings: [],

                nilai: [],


                // ======================================
                // FILTER
                // ======================================

                selectedProdi: '',

                selectedPembimbing: '',

                search: '',


                // ======================================
                // STATUS
                // ======================================

                loadingProdi: false,

                loadingPembimbing: false,

                loadingNilai: false,

                sudahCari: false,

                copySuccess: false

            },


            computed: {


                // ======================================
                // NAMA PEMBIMBING
                // ======================================

                selectedPembimbingNama() {

                    const pembimbing =
                        this.pembimbings.find(
                            item =>
                            item.pembimbing_id ==
                            this.selectedPembimbing
                        );


                    return pembimbing ?
                        pembimbing.nama_lengkap :
                        '';

                },


                // ======================================
                // SEARCH DATA
                // ======================================

                filteredNilai() {

                    if (!this.search) {

                        return this.nilai;

                    }


                    const keyword =
                        this.search.toLowerCase();


                    return this.nilai.filter(item => {

                        const nim =
                            item.nim ?
                            item.nim.toLowerCase() :
                            '';


                        const nama =
                            item.nama_lengkap ?
                            item.nama_lengkap.toLowerCase() :
                            '';


                        return (
                            nim.includes(keyword) ||
                            nama.includes(keyword)
                        );

                    });

                }

            },


            mounted() {

                this.loadProdi();

                this.loadPembimbing();

            },


            methods: {


                // ======================================
                // LOAD PRODI
                // ======================================

                loadProdi() {

                    this.loadingProdi = true;


                    axios.get(
                            '/api/import-siakad/kuliah-lapangan/13/prodi'
                        )


                        .then(response => {

                            this.prodis =
                                response.data.data;

                        })


                        .catch(error => {

                            console.error(error);

                            alert(
                                'Gagal mengambil data program studi.'
                            );

                        })


                        .finally(() => {

                            this.loadingProdi = false;

                        });

                },


                // ======================================
                // LOAD PEMBIMBING
                // ======================================

                loadPembimbing() {

                    this.loadingPembimbing = true;


                    axios.get(
                            '/api/import-siakad/kuliah-lapangan/13/pembimbing'
                        )


                        .then(response => {

                            this.pembimbings =
                                response.data.data;

                        })


                        .catch(error => {

                            console.error(error);

                            alert(
                                'Gagal mengambil data pembimbing.'
                            );

                        })


                        .finally(() => {

                            this.loadingPembimbing = false;

                        });

                },


                // ======================================
                // LOAD NILAI
                // ======================================

                loadNilai() {

                    this.loadingNilai = true;

                    this.sudahCari = true;

                    this.copySuccess = false;


                    // ==================================
                    // PARAMETER
                    // ==================================

                    const params = {};


                    if (this.selectedProdi) {

                        params.prodi =
                            this.selectedProdi;

                    }


                    if (this.selectedPembimbing) {

                        params.pembimbing =
                            this.selectedPembimbing;

                    }


                    // ==================================
                    // REQUEST
                    // ==================================

                    axios.get(
                            '/api/import-siakad/kuliah-lapangan/13/nilai', {
                                params: params
                            }
                        )


                        .then(response => {

                            console.log(
                                'Data nilai:',
                                response.data
                            );


                            this.nilai =
                                response.data.data;

                        })


                        .catch(error => {

                            console.error(error);

                            alert(
                                'Gagal mengambil data nilai mahasiswa.'
                            );

                        })


                        .finally(() => {

                            this.loadingNilai = false;

                        });

                },


                // ======================================
                // FORMAT NILAI
                // ======================================

                formatNilai(value) {

                    if (
                        value === null ||
                        value === undefined ||
                        value === ''
                    ) {

                        return '-';

                    }


                    return Number(value)
                        .toFixed(2)
                        .replace('.', ',');

                },


                // ======================================
                // COPY TABEL
                //
                // HANYA:
                //
                // NIM
                // NAMA
                // NILAI AKHIR
                // ======================================

                copyTable() {

                    if (
                        !this.filteredNilai.length
                    ) {

                        alert(
                            'Tidak ada data untuk dicopy.'
                        );

                        return;

                    }


                    let text =
                        'NIM\tNama\tNilai Akhir\n';


                    this.filteredNilai.forEach(item => {

                        text +=
                            (item.nim || '') +
                            '\t' +

                            (item.nama_lengkap || '') +
                            '\t' +

                            (
                                item.nilai_final !== null ?
                                item.nilai_final :
                                ''
                            ) +

                            '\n';

                    });


                    // ==================================
                    // COPY KE CLIPBOARD
                    // ==================================

                    navigator.clipboard.writeText(text)

                        .then(() => {

                            this.copySuccess = true;


                            setTimeout(() => {

                                this.copySuccess = false;

                            }, 3000);

                        })


                        .catch(error => {

                            console.error(error);

                            alert(
                                'Gagal menyalin data.'
                            );

                        });

                }

            }

        });
    </script>


</body>

</html>