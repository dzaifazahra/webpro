<?php
include '../auth/cek_login.php';
include '../koneksi.php';

if ($_SESSION['role'] != 'kasir') {
    header("Location: ../auth/login.php");
    exit;
}

$barang = mysqli_query($conn,
          "SELECT * FROM barang WHERE jumlah > 0");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kasir Transaksi</title>

    <style>

        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial;
        }

        body{
            background: #f4f4f4;
        }

        .container{
            display: flex;
            gap: 20px;
            padding: 20px;
        }

        /* PRODUK */

        .produk-area{
            flex: 3;
        }

        .produk-grid{
            display: grid;
            grid-template-columns: repeat(auto-fill,minmax(220px,1fr));
            gap: 20px;
        }

        .card{
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .card h3{
            margin-bottom: 10px;
        }

        .card p{
            margin: 5px 0;
        }

        .card button{
            width: 100%;
            padding: 10px;
            margin-top: 15px;
            border: none;
            background: royalblue;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }

        /* CART */

        .cart{
            flex: 1;
            background: white;
            padding: 20px;
            border-radius: 10px;
            height: fit-content;
            position: sticky;
            top: 20px;
        }

        .cart-item{
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }

        .cart-item h4{
            margin-bottom: 5px;
        }

        .total{
            margin-top: 20px;
            font-size: 22px;
            font-weight: bold;
        }

        .cart input{
            width: 100%;
            padding: 10px;
            margin-top: 15px;
        }

        .btn{
            width: 100%;
            padding: 12px;
            border: none;
            color: white;
            margin-top: 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .bayar{
            background: green;
        }

        .batal{
            background: crimson;
        }

        .kembalian{
            margin-top: 15px;
            padding: 10px;
            background: #f0f0f0;
            border-radius: 5px;
        }

        .nav{
    margin-bottom: 20px;
}

.nav a{
    text-decoration: none;
    padding: 10px 15px;
    background: royalblue;
    color: white;
    border-radius: 5px;
    margin-right: 10px;
}

.logout{
    background: crimson !important;
}

    </style>
</head>
<body>

<form action="proses_transaksi.php" method="POST">

<div class="container">

    <!-- PRODUK -->

    <div class="produk-area">
       <h2>Daftar Produk</h2> 
    <div class="nav">
    
    <br>
    
    <a href="riwayat.php">
        Riwayat
    </a>

    <a class="logout"
       href="../auth/logout.php">
        Logout
    </a>
    
</div>
        

        <br>

        <div class="produk-grid">

        <?php while($row = mysqli_fetch_assoc($barang)){ ?>

            <div class="card">

                <h3><?= $row['nama_barang']; ?></h3>

                <p>
                    Harga :
                    Rp <?= number_format($row['harga']); ?>
                </p>

                <p>
                Stok :
                <?= $row['jumlah']; ?>
                </p>

                <?php if($row['jumlah'] <= 5){ ?>

                <p style="
                 color: crimson;
                 font-weight: bold;
                 margin-top: 8px;">
                  ⚠ Stok Hampir Habis
                 </p>

                <?php } ?>

                <p>
                    Kategori :
                    <?= $row['kategori']; ?>
                </p>

                <button type="button"
                    onclick="tambahCart(
                        '<?= $row['id']; ?>',
                        '<?= $row['nama_barang']; ?>',
                        '<?= $row['harga']; ?>'
                    )">

                    Tambah

                </button>

            </div>

        <?php } ?>

        </div>

    </div>

    <!-- CART -->

    <div class="cart">

        <h2>Cart</h2>

        <div id="cart-list"></div>

        <div class="total">
            Total :
            Rp <span id="total">0</span>
        </div>

        <input type="number"
               id="bayar"
               placeholder="Jumlah Bayar"
               onkeyup="hitungKembalian()">

        <div class="kembalian">
            Kembalian :
            Rp <span id="kembalian">0</span>
        </div>

        <button type="submit"
                class="btn bayar">
            Bayar
        </button>

        <button type="button"
                class="btn batal"
                onclick="resetCart()">
            Batal
        </button>

    </div>

</div>

<div id="hidden-input"></div>

<input type="hidden" name="total_harga" id="total_harga">
<input type="hidden" name="uang_bayar" id="uang_bayar">

</form>

<script>

let cart = [];

function tambahCart(id, nama, harga, stok){

let existing = cart.find(item => item.id == id);

if(existing){

    if(existing.qty >= stok){

        alert('Stok tidak mencukupi!');

        return;
    }

    existing.qty += 1;

} else {

    cart.push({
        id: id,
        nama: nama,
        harga: parseInt(harga),
        qty: 1,
        stok: parseInt(stok)
    });
}

renderCart();
}

function renderCart(){

let cartList = document.getElementById('cart-list');
let hidden = document.getElementById('hidden-input');

cartList.innerHTML = '';
hidden.innerHTML = '';

let total = 0;

cart.forEach((item,index)=>{

    let subtotal = item.harga * item.qty;

    total += subtotal;

    cartList.innerHTML += `

        <div class="cart-item">

            <h4>${item.nama}</h4>

            <p>
                Rp ${item.harga.toLocaleString()}
            </p>

            <div style="
                display:flex;
                align-items:center;
                gap:10px;
                margin-top:10px;
            ">

                <button type="button"
                    onclick="kurangQty(${index})"
                    style="
                        width:35px;
                        height:35px;
                        border:none;
                        background:crimson;
                        color:white;
                        border-radius:5px;
                        cursor:pointer;
                    ">
                    -
                </button>

                <span style="
                    font-size:18px;
                    font-weight:bold;
                ">
                    ${item.qty}
                </span>

                <button type="button"
                    onclick="tambahQty(${index})"
                    style="
                        width:35px;
                        height:35px;
                        border:none;
                        background:green;
                        color:white;
                        border-radius:5px;
                        cursor:pointer;
                    ">
                    +
                </button>

            </div>

            <p style="margin-top:10px;">
                Subtotal :
                Rp ${subtotal.toLocaleString()}
            </p>

            <button type="button"
                onclick="hapusItem(${index})"
                style="
                    width:100%;
                    padding:8px;
                    margin-top:10px;
                    border:none;
                    background:black;
                    color:white;
                    border-radius:5px;
                    cursor:pointer;
                ">

                Hapus

            </button>

        </div>

    `;

    hidden.innerHTML += `

        <input type="hidden"
               name="barang_id[]"
               value="${item.id}">

        <input type="hidden"
               name="jumlah[${item.id}]"
               value="${item.qty}">

    `;
});

document.getElementById('total').innerText =
    total.toLocaleString();

document.getElementById('total_harga').value = total;

hitungKembalian();
}

function tambahQty(index){

let item = cart[index];

let stok = parseInt(item.stok);

if(item.qty >= stok){

    alert('Jumlah melebihi stok!');

    return;
}

cart[index].qty += 1;

renderCart();
}

function kurangQty(index){

if(cart[index].qty > 1){

    cart[index].qty -= 1;

} else {

    hapusItem(index);
}

renderCart();
}

function hapusItem(index){

cart.splice(index,1);

renderCart();
}

function ubahQty(index, qty){

    cart[index].qty = parseInt(qty);

    renderCart();
}

function resetCart(){

    cart = [];

    renderCart();

    document.getElementById('bayar').value = '';

    document.getElementById('kembalian').innerText = '0';
}

function hitungKembalian(){

    let total = parseInt(
        document.getElementById('total_harga').value || 0
    );

    let bayar = parseInt(
        document.getElementById('bayar').value || 0
    );

    document.getElementById('uang_bayar').value = bayar;

    let kembali = bayar - total;

    if(kembali < 0){
        kembali = 0;
    }

    document.getElementById('kembalian').innerText =
        kembali.toLocaleString();
}

history.pushState(null, null, location.href);
window.onpopstate = function () {
    history.go(1);
};

</script>

</body>
</html>