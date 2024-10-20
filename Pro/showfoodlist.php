<?php
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "shabudbtest";

$conn = new mysqli($hostname, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM foodlist";
$result = $conn->query($sql);

// กำหนดค่า customer_id ปัจจุบันจาก GET parameter ถ้ามี
$current_customer_id = isset($_GET['customer_id']) ? intval($_GET['customer_id']) : 1;
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายการอาหาร</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=table_restaurant" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100..900&display=swap');

        * {
            font-family: "Noto Sans Thai", sans-serif;
        }

        .slide-panel {
            position: fixed;
            top: 0;
            right: -100%;
            width: 100%;
            max-width: 400px;
            height: 100%;
            background-color: white;
            transition: right 0.3s ease-in-out;
            box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            display: flex;
            flex-direction: column;
        }

        .slide-panel.open {
            right: 0;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            z-index: 999;
        }
    </style>
</head>

<body class="bg-gradient-to-r from-blue-100 to-purple-100 min-h-screen">
    <div style="position: fixed; top: 20px; right: 20px; z-index: 1000;">
        <button id="customerIdButton" class="bg-slate-900 hover:scale-105 hover:bg-blue-950" style="color: #848bbf;  border-radius: 50%; width: 70px; height: 70px; border: none;">
            <span class="material-symbols-outlined" style="font-size: 35px;">
                table_restaurant
            </span>
        </button>
        <div id="customerIdDropdown" style="width: 180px; display: none; position: absolute; top: 80px; right: 0; background-color: white; border: 1px solid #ccc; padding: 10px; text-align: center;">
            <label for="customerIdSelect">เลือกโต๊ะ</label>
            <div>
                <select id="customerIdSelect" class="w-full">
                    <?php for ($i = 1; $i <= 10; $i++): ?>
                        <option value="<?= $i ?>" <?= $i == $current_customer_id ? 'selected' : '' ?>>
                            <?= $i ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>
        </div>
    </div>

    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold text-center mb-2 text-gray-800 shadow-text">รายการอาหาร</h1>
        <p class="text-center text-gray-700 mb-8">โต๊ะที่ : <span class="font-semibold text-lg text-gray-900"><?= $current_customer_id ?></span></p> <!-- แสดง Customer_ID -->

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
            while ($row = $result->fetch_assoc()) {
                $id = $row['ID'];
                $name = $row['Name'];
                $image = $row['Image'];
            ?>
                <div class="bg-white rounded-lg shadow-lg overflow-hidden transform transition duration-300 hover:scale-105">
                    <img src="<?php echo $image; ?>" alt="<?php echo $name; ?>" class="w-full h-70 object-cover">
                    <div class="p-4">
                        <h2 class="text-xl font-semibold text-center mb-3 text-gray-800"><?php echo $name; ?></h2>
                        <div class="flex justify-center items-center space-x-3">
                            <button class="decrease-btn bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-full transition duration-300" onclick="adjustQuantity(<?php echo $id; ?>, -1)">-</button>
                            <span id="quantity-<?php echo $id; ?>" class="font-medium text-xl w-8 text-center">0</span>
                            <button class="increase-btn bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-full transition duration-300" onclick="adjustQuantity(<?php echo $id; ?>, 1)">+</button>
                        </div>
                    </div>
                </div>
            <?php
            }
            $conn->close();
            ?>
        </div>
        <div class="mt-8 text-center">
            <button id="confirmButton" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-full shadow-lg transform transition duration-300 hover:scale-105">
                ยืนยัน
            </button>
        </div>
    </div>

    <div class="overlay" id="overlay"></div>
    <div class="slide-panel" id="slidePanel">
        <div class="p-4 flex flex-col h-full">
            <h2 class="text-2xl font-bold mb-4">รายการที่สั่ง</h2>
            <div id="orderList" class="mb-4 flex-grow"></div>
            <div class="flex justify-between mt-auto">
                <button id="cancelOrder" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
                    ยกเลิก
                </button>
                <button id="finalConfirm" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                    ยืนยันการสั่ง
                </button>
            </div>
        </div>
    </div>

    <script>
        // แสดง/ซ่อน dropdown เมื่อคลิกปุ่ม
        document.getElementById('customerIdButton').addEventListener('click', function() {
            var dropdown = document.getElementById('customerIdDropdown');
            dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
        });

        // เมื่อผู้ใช้เปลี่ยนค่า Customer_ID
        document.getElementById('customerIdSelect').addEventListener('change', function() {
            var selectedCustomerId = this.value;
            window.location.href = "?customer_id=" + selectedCustomerId;
        });

        // ฟังก์ชันจัดการปริมาณอาหาร
        const quantities = {};

        function adjustQuantity(id, amount) {
            const quantityElement = document.getElementById(`quantity-${id}`);
            let quantity = parseInt(quantityElement.textContent);
            quantity = Math.max(0, Math.min(5, quantity + amount));
            quantityElement.textContent = quantity;
            quantities[id] = quantity;

            const card = quantityElement.closest('.bg-white');
            const decreaseBtn = card.querySelector('.decrease-btn');
            const increaseBtn = card.querySelector('.increase-btn');

            decreaseBtn.disabled = quantity === 0;
            increaseBtn.disabled = quantity === 5;

            decreaseBtn.classList.toggle('opacity-50', quantity === 0);
            increaseBtn.classList.toggle('opacity-50', quantity === 5);
        }

        // ยืนยันคำสั่งซื้อ
        document.getElementById('confirmButton').addEventListener('click', function() {
            const orderList = document.getElementById('orderList');
            orderList.innerHTML = '';
            let hasItems = false;

            for (const [id, quantity] of Object.entries(quantities)) {
                if (quantity > 0) {
                    hasItems = true;
                    const name = document.querySelector(`#quantity-${id}`).closest('.bg-white').querySelector('h2').textContent;
                    orderList.innerHTML += `<div class="flex justify-between items-center mb-2"><span>${name}</span><span class="font-bold">${quantity}</span></div>`;
                }
            }

            if (hasItems) {
                document.getElementById('slidePanel').classList.add('open');
                document.getElementById('overlay').style.display = 'block';
            } else {
                alert('กรุณาเลือกอาหารอย่างน้อย 1 รายการ');
            }
        });

        // ยกเลิกคำสั่งซื้อ
        document.getElementById('cancelOrder').addEventListener('click', function() {
            document.getElementById('slidePanel').classList.remove('open');
            document.getElementById('overlay').style.display = 'none';
        });

        // ยืนยันการสั่งขั้นสุดท้าย
        document.getElementById('finalConfirm').addEventListener('click', function() {
            // รับ customer_id ที่เลือกจาก dropdown
            var customerId = document.getElementById('customerIdSelect').value;

            $.ajax({
                url: 'save_order.php',
                type: 'POST',
                data: {
                    order: JSON.stringify(quantities), // ข้อมูลรายการอาหาร
                    customer_id: customerId // ส่งค่า customer_id ไปด้วย
                },
                success: function(response) {
                    alert('ยืนยันการสั่งอาหารเรียบร้อย!');
                    resetOrder();
                },
                error: function() {
                    alert('เกิดข้อผิดพลาดในการบันทึกคำสั่งซื้อ');
                }
            });
        });


        document.getElementById('overlay').addEventListener('click', function() {
            document.getElementById('slidePanel').classList.remove('open');
            document.getElementById('overlay').style.display = 'none';
        });

        // รีเซ็ตคำสั่งซื้อ
        function resetOrder() {
            for (const id of Object.keys(quantities)) {
                document.getElementById(`quantity-${id}`).textContent = '0';
                quantities[id] = 0;
            }
            document.getElementById('slidePanel').classList.remove('open');
            document.getElementById('overlay').style.display = 'none';
        }
    </script>
</body>

</html>