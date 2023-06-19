<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>
            {{ @$title != '' ? "$title |": '' }}
            {{ settings()->get('app_name', 'My APP') }}
        </title>

		<style>
			.invoice-box {
				max-width: 800px;
				margin: auto;
				padding: 30px;
				border: 1px solid #eee;
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
				font-size: 16px;
				line-height: 24px;
				font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
				color: #555;
			}

			.invoice-box table {
				width: 100%;
				line-height: inherit;
				text-align: left;
			}

			.invoice-box table td {
				vertical-align: top;
			}

			.invoice-box table tr td:nth-child(2) {
				text-align: right;
			}

			.invoice-box table tr.top table td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.top table td.title {
				font-size: 45px;
				line-height: 45px;
				color: #333;
			}

			.invoice-box table tr.information table td {
			}

			.invoice-box table tr.heading td {
				background: #eee;
				border-bottom: 1px solid #ddd;
				font-weight: bold;
			}

			.invoice-box table tr.details td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.item td {
				border-bottom: 1px solid #eee;
			}

			.invoice-box table tr.item.last td {
				border-bottom: none;
			}

			.invoice-box table tr.total td:nth-child(2) {
				border-top: 2px solid #eee;
				font-weight: bold;
			}

			@media only screen and (max-width: 600px) {
				.invoice-box table tr.top table td {
					width: 100%;
					display: block;
					text-align: center;
				}

				.invoice-box table tr.information table td {
					width: 100%;
					display: block;
					text-align: center;
				}
			}

			/** RTL **/
			.invoice-box.rtl {
				direction: rtl;
				font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
			}

			.invoice-box.rtl table {
				text-align: right;
			}

			.invoice-box.rtl table tr td:nth-child(2) {
				text-align: left;
			}
            .d-flex {
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            /* .d-flex img {
                margin-right: 10px;
            } */
            .d-flex h5 {
                margin-top: 0px;
            }
            .d-flex h4 {
                margin-bottom: 0px;
            }
            .button {
                display: inline-block;
                font-family: 'Times New Roman', Times, serif;
                padding: 5px 10px;
                background-color: #21779c;
                color: #fff;
                text-decoration: none;
                border-radius: 5px;
                font-weight: bold;
            }
            .table-tagihan{
                border: 2px solid black;
                border-collapse: collapse;
                margin-bottom: 1rem;
            }
            .table-tagihan th{
                border: 2px solid black;
                text-align: center;
                color: white;
                background:#217091;
                padding: 4px;
            }
            .table-tagihan td{
                border: 2px solid black;
                padding: 4px;
            }
		</style>
	</head>

	<body>
		<div class="invoice-box">
            {{-- <div class="d-flex"> --}}
                {{-- <img src="{{ asset('storage/images/fania.png') }}" width="120px"> --}}
                {{-- <h4>SMK FANIA SALSABILA</h4>
                <h5>Kota Jambi</h5>
            </div> --}}
			<table cellpadding="0" cellspacing="0">
                <tr>
                    <td width="80">
                        @if (request('output') == 'pdf')
                            <img src="{{ public_path() . '/storage/images/fania.png' }}" alt="" width="110">
                        @else
                        <img src="{{ asset('storage/images/fania.png') }}" alt="" width="110">
                        @endif
                    </td>
                    <td style="text-align:left; vertical-align: middle">
                        <div style="font-size: 20px; font-weight:bold">{{ settings()->get('app_name','My App') }}</div>
                        <div>{{ settings()->get('app_address') }}</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <hr>
                    </td>
                </tr>
				<tr class="information">
					<td colspan="3">
						<table>
							<tr>
								<td>
									Tagihan Untuk : {{ $siswa->nama }} ({{ $siswa->nisn }})<br />
									Kelas : {{ $siswa->kelas }}<br />
									Jurusan : {{ $siswa->jurusan }}
								</td>
							</tr>
						</table>
                        <hr>
					</td>
				</tr>
				<tr>
                    <td colspan="2">
                        <table width="100" class="table-tagihan">
                            <tr class="heading">
                                <th width="1%" style="text-align: center;">No</th>
                                <th style="text-align:start;">Bulan</th>
                                <th style="text-align:center;">Jumlah Tagihan</th>
                                <th style="text-align:center;">Tanggal Bayar</th>
                                <th>Paraf</th>
                                <th>Keterangan</th>
                            </tr>
                            @foreach ($tagihan as $item)
                                <tr class="item">
                                    <td style="text-align:center">{{ $loop->iteration }}</td>
                                    <td style="text-align:start">{{ $item['bulan']. ' '.$item['tahun'] }}</td>
                                    <td style="text-align:end">{{ formatRupiah($item['total_tagihan'])}}</td>
                                    <td style="text-align:end">{{ $item['tanggal_bayar'] }}</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            @endforeach
                            <tr>
                        </table>
                    </td>
                </tr>
                    <td colspan="3">
                        jambi, {{ now()->translatedFormat('d, F Y') }} <br>
                        Mengetahui,<br>
                        <br>
                        <br>
                        Bendahara
                    </td>
                </tr>
			</table>
            <div style="display: flex; justify-content:end;">
                <br>
            <a href="{{ url()->full() . '&output=pdf' }}" class="button" style="margin-right: 15px;">Download PDF</a>
            <a href="#" onclick="window.print()" class="button">Cetak</a>
            </div>
		</div>
	</body>
</html>
