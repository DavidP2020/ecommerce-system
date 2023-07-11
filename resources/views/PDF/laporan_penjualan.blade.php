<style type="text/css">
*{
    margin:0;
    padding: 0;
    outline: 0;
}
.filter{
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#e94ca1",endColorstr="#c74ae9",GradientType=1);
    opacity: .7; 
    flex-direction: column;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 50px;
    margin-bottom: 50px;
}
table{
    width: 95%; 
    border-collapse: collapse;
    border-spacing: 0;
    box-shadow: 0 2px 15px rgba(64,64,64,.7);
    border-radius: 12px 12px 0 0;
    overflow: hidden;
}
td , th{
    padding: 15px 20px;
    text-align: center;
}
th{
    background-color: black;
    color: #fafafa;
    font-size: 12px;
    font-family: 'Open Sans',Sans-serif;
    font-weight: 200;
    text-transform: uppercase;
}
tr{
    width: 100%;
    background-color: #fafafa;
    font-family: 'Montserrat', sans-serif;
    font-weight: bold;
    font-size: 10px;
}
tr:nth-child(even){
    background-color: #eeeeee;
    font-weight: bold;
    font-size: 10px;
}
.text{
    text-align: center;
    margin:40px;
}
.laporan{
    font-weight: bold;
    margin-left: 40px;
    display: flex;
    font-size: 16px;
    flex-direction: row;
    justify-content: center;
    align-items: center;
}
.laporan_transaksi{
    width: 100%;
}
.keuntungan{
    font-weight: bold;
    font-size: 16px;
    text-align: right;
    width: 95%; 
}
</style>
<body>

    <h1 class="text">
        Laporan Penjualan Tahun
    </h1>
    <div class="laporan">
        <div class="laporan_transaksi">
            <div>
                Total Transaksi :
            </div>
        </div>
        <div class="laporan_transaksi">
            <div>
                Total Transaksi yang Sudah DiBayar :
            </div>
            <div>
                Total Transaksi yang Belum DiBayar :
            </div>
            <div>
                Total Transaksi yang Dibatalkan :
            </div>
        </div>
        <div class="laporan_transaksi">
            <div>
                Total Transaksi yang Sudah Diselesaikan :
            </div>
            <div>
                Total Transaksi yang Masih Diproses :
            </div>
        </div>
    </div>
    
    <div class="filter">
    <table >
        <tr>
            <th>NO</th>
            <th>Order ID</th>
            <th>Email</th>
            <th>Phone Number</th>
            <th>Payment Mode</th>
            <th>Gross Amount</th>
            <th>Ongkir</th>
            <th>Paid By</th>
            <th>Cancel By</th>
            <th>Accept By</th>
            <th>Finish By</th>
            <th>Status</th>
            <th>Status Orderan</th>
        </tr>
        <tr>
            <td>1</td>
            <td>Jean</td>
            <td>leBon</td>
            <td>1368</td>
            <td>18 Nov 1962</td>
            <td>5000$</td>
            <td>2</td>
            <td>jack</td>
            <td>Duppont</td>
            <td>1368</td>
            <td>18 Dec 1962</td>
            <td>2000$</td>
            <td>2000$</td>
        </tr>
    </table>
</div>
    <div class="keuntungan">
        Penghasilan Tahun Ini :
    </div>
</body>