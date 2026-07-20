<br />Hi {{ name }},<br />

<p>Berikut kami informasikan Tagihan baru anda, yang telah dibuat pada <b>{{ inv_date }}</b><br />

    <table>
        <tr>
            <td>Nomor Tagihan</td>
            <td>:</td>
            <td>{{ inv_number }}</td>
        </tr>
        <tr>
            <td>Jatuh Tempo Tagihan</td>
            <td>:</td>
            <td>{{ inv_due }}</td>
        </tr>
        <tr>
            <td>Metode Pembayaran</td>
            <td>:</td>
            <td>Bank Transfer</td>
        </tr>
    </table>

    <h3>Detail Tagihan Layanan :</h3>

    <table style="width:100%">
        <tr>
            <th style="background:#00a9e9;padding:10px;width:70%;color:#fff">Item Tagihan</th>
            <th style="background:#00a9e9;padding:10px;width:30%;color:#fff">Amount</th>
        </tr>
        {{ #each invoice_item }}
        <tr>
            <td style="padding:5px">{{ item_name }} </td>
            <td style="padding:5px;text-align:right;">{{ item_amount }}</td>
        </tr>
        {{ else }}

        {{ /each }}
        <tr>
            <td style="padding:5px;"><b>Sub Tagihan / Amount</b></td>
            <td style="padding:5px;text-align:right;">{{ sub_tagihan }}</td>
        </tr>
        {{ #each invoice_item_promo }}
        <tr>
            <td style="padding:2px">{{ item_name }} </td>
            <td style="padding:5px;text-align:right;">{{ item_amount }}</td>
        </tr>
        {{ else }}

        {{ /each }}
        <tr>
            <td style="padding:5px;"><b>Jumlah Tagihan</b></td>
            <td style="padding:5px;text-align:right;">{{ subtotal }}</td>
        </tr>
        <tr>
            <td style="padding:5px;"><b>Dasar Pengenaan Pajak</b></td>
            <td style="padding:5px;text-align:right;">{{ tax }}</td>
        </tr>
        <tr>
            <td style="padding:5px;">
                <h4>Total Tagihan</b>
            </td>
            <td style="padding:5px;text-align:right;">{{ total }}</td>
        </tr>
    </table>
    <br />
    <p style="text-align:center;">Mohon melakukan pembayaran paling lambat tanggal <b>{{ inv_due }}</b> dengan nominal
        sejumlah :</p>
    <h1 style="text-align:center;">{{ total }}</h1>
    <p style="text-align:center;">Pembayaran dialamatkan kepada :</p>
    <table style="border:3px solid #00a9e9;width:100%;" cellpadding="0" cellspacing="0">
        <tr style="background:#00a9e9;">
            <td style="padding:10px;color:#fff;text-align:center;">
                Bank Account : {{ $company['bank_name'] }}<br />
                Account Name : {{ $company['name'] }}
            </td>
        </tr>
        <tr>
            <td style="padding:10px;text-align:center;">
                <b>Account No : 7660600668</b>
            </td>
        </tr>
    </table>
    <br />
    <div style="text-align:center;padding:15px;border-radius:4px;background:#f9f9f9">
        <h3>Konfirmasi Pembayaran</h3>
        Bagi pelanggan yang telah melakukan transfer pembayaran, mohon konfirmasi ke bagian
        Billing dengan mengirim bukti tranfer melalui email atau fax.
    </div>
    <br />

    <h3 style="text-align:center">Informasi layanan Billing :</h3>
    <div style="text-align:center">
        Telp : 021 - 7940911<br />
        Email : Finance@uni.net.id<br />
    </div>
    <br />

    <div style="padding:15px;border-radius:4px;background:#fff8d4;color:#583602;">
        <h4>Catatan :</h4>
        - Pembayaran akan diakui setelah kami menerima konfirmasi pembayaran <br />
        - Invoice ini berlaku sebagai tanda terima yang sah setelah konfirmasi
        - Layanan akan kami suspended apabila tagihan tidak dilakukan pembayaran melebihi dari tanggal jatuh tempo
    </div>
    <br />
    <p>Terima Kasih</p>
