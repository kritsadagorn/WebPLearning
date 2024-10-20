<?php
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "shabudbtest";

$conn = new mysqli($hostname, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM admintable ORDER BY timeOrder ASC";
$result = $conn->query($sql);

$foodNames = [];
$foodSql = "SELECT ID, Name FROM foodlist";
$foodResult = $conn->query($foodSql);
while ($foodRow = $foodResult->fetch_assoc()) {
    $foodNames[$foodRow['ID']] = $foodRow['Name'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100..900&display=swap');

        * {
            font-family: "Noto Sans Thai", sans-serif;
        }

        .bg-gray-row {
            background-color: #e0e4bf;
        }

        .bg-white-row {
            background-color: #e4bfbf;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">รายการสั่งอาหาร</h1>
        <div class="overflow-x-auto">
            <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="py-2 px-4 text-left">สำเร็จ</th>
                        <th class="py-2 px-4 text-left">เวลา-วัน</th>
                        <th class="py-2 px-4 text-left">โต๊ะที่</th>
                        <th class="py-2 px-4 text-left">รายการที่</th>
                        <?php
                        foreach ($foodNames as $name) {
                            echo "<th class='py-2 px-4 text-left'>{$name}</th>";
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $prevCustomerID = null;
                    $isGray = false;

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            if ($prevCustomerID !== $row['Customer_ID']) {
                                $isGray = !$isGray;
                            }

                            $rowClass = $isGray ? 'bg-gray-row' : 'bg-white-row';

                            echo "<tr class='{$rowClass} border-b'>";
                            echo "<td class='py-2 px-4'><input type='checkbox' class='delete-checkbox' data-orderlist='{$row['orderList']}' data-customerid='{$row['Customer_ID']}'></td>";
                            echo "<td class='py-2 px-4'>{$row['timeOrder']}</td>";
                            echo "<td class='py-2 px-4'>{$row['Customer_ID']}</td>";
                            echo "<td class='py-2 px-4'>{$row['orderList']}</td>";
                            for ($i = 1; $i <= 15; $i++) {
                                echo "<td class='py-2 px-4'>" . ($row[$i] ?? '-') . "</td>";
                            }
                            echo "</tr>";

                            $prevCustomerID = $row['Customer_ID'];
                        }
                    } else {
                        echo "<tr><td colspan='20' class='py-2 px-4 text-center'>ไม่มีข้อมูล</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="mt-4 text-center">
            <button id="delete-selected" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                ลบรายการที่เลือก
            </button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButton = document.getElementById('delete-selected');
            deleteButton.addEventListener('click', function() {
                const checkboxes = document.querySelectorAll('.delete-checkbox:checked');
                console.log('Selected checkboxes:', checkboxes.length); // เพิ่มบรรทัดนี้เพื่อตรวจสอบ

                const ordersToDelete = Array.from(checkboxes).map(cb => ({
                    orderList: cb.getAttribute('data-orderlist'),
                    customerId: cb.getAttribute('data-customerid')
                }));

                console.log('Orders to delete:', ordersToDelete); // เพิ่มบรรทัดนี้เพื่อตรวจสอบ

                if (ordersToDelete.length === 0) {
                    alert('กรุณาเลือกรายการที่ต้องการลบ');
                    return;
                }

                if (confirm('คุณแน่ใจหรือไม่ที่จะลบรายการที่เลือก?')) {
                    fetch('delete_orders.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                orders: ordersToDelete
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('ลบรายการเรียบร้อยแล้ว');

                                document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                                    checkbox.checked = false;
                                });
                                location.reload();
                            } else {
                                alert('เกิดข้อผิดพลาดในการลบรายการ: ' + data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์');
                        });
                }
            });
        });
    </script>
</body>

</html>

<?php
$conn->close();
?>