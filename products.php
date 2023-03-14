<?php
class Products
{
    public function getproduct()
    {
        header('Content-Type: application/json; charset=utf-8');
        $sql = 'SELECT * from products';
        $con = mysqli_connect(DATABASE, USERNAME, PASSWORD, DATEBASE);
        $req = mysqli_query($con, $sql);
        if ($req) {
            while ($row = mysqli_fetch_assoc($req)) {
                $data[] = $row;
            }
            echo json_encode($data, JSON_PRETTY_PRINT);
        }
    }
    public function newproduct($requests = null, $imagerequests = null)
    {
        header('Content-Type: application/json; charset=utf-8');
        $message = [];
        $con = mysqli_connect(DATABASE, USERNAME, PASSWORD, DATEBASE);
        $name = mysqli_real_escape_string($con, $requests['name']);
        $description = mysqli_real_escape_string($con, $requests['description']);
        $price = mysqli_real_escape_string($con, $requests['price']);
        if ($imagerequests) {
            $file_name = $imagerequests['image']['name'];
            $file_size = $imagerequests['image']['size'];
            $file_tmp = $imagerequests['image']['tmp_name'];
            $file_type = $imagerequests['image']['type'];
            $valid_extensions = array("jpg", "jpeg", "png");
            $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            if (!in_array($file_extension, $valid_extensions)) {
                exit();
            }
            $max_file_size = 10 * 1024 * 1024; // 10 MB
            if ($file_size > $max_file_size) {
                exit();
            }
            $new_file_name = uniqid() . '.' . $file_extension;
            $upload_dir = "uploads/";
            $upload_path = $upload_dir . $new_file_name;
            move_uploaded_file($file_tmp, $upload_path);
        }

        $sql = "INSERT INTO `products`(`name`, `description`, `image`, `price`, `date`) VALUES ('$name','$description','$upload_path', '$price', NOW())";
        $req = mysqli_query($con, $sql);
        if ($req) {
            $message['status'] = 200;
            $message['message'] = 'success';
            echo json_encode($message, JSON_PRETTY_PRINT);
        } else {
            $message['status'] = 500;
            $message['message'] = mysqli_error($con);
            echo json_encode($message, JSON_PRETTY_PRINT);
        }
    }
}


?>