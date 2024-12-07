<?php
namespace App\Controller;

use App\Database\Connection;
use App\Helper\DateTime;
use App\Helper\Auth;
use Exception;
use App\Helper\Paginator;
use App\Helper\FileUpload;
use App\Helper\ThrowError;


class UserController {
    private $connect;

    function __construct() {
        $connection = new Connection();
        $this->connect = $connection->connect();
    }

    // register 
    public function register($request) {
        $name = $request['name'];
        $email = $request['email'];
        $password = password_hash($request['password'], PASSWORD_DEFAULT);
        $userType = 'user';

        // $dataTime = new DateTime();
        $created_at = DateTime::getDate("Y-m-d H:i:s");

        $sql = "INSERT INTO users (name, email, password, user_type, created_at) 
                VALUES ('$name', '$email', '$password', '$userType', '$created_at')";

        try {
            $data = $this->connect->query($sql);
            Auth::make([
                'id' => $this->connect->insert_id,
                'name' => $name,
                'email' => $email,
                'avatar' => null,
                'shipping_address' => null,
                'user_type' => $userType,
                'created_at' => $created_at
            ]);
            header("Location: index.php");
            exit();
        } catch (Exception $err) {
            echo "<div class='err-exception-con'>$err</div>";
        }
    }


    // Login 
    public function login($request) {
        $email = $request['email'];
        $password = $request['password'];

        $sql = "SELECT * FROM users WHERE email='$email'";
        $query = $this->connect->query($sql);

        if($query->num_rows > 0) {
            $user = $query->fetch_assoc();
            // return $user;
            if(password_verify($password, $user['password'])) {
                Auth::make([
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'avatar' => $user['avatar'],
                    'shipping_address' => $user['shipping_address'],
                    'user_type' => $user['user_type'],
                    'created_at' => $user['created_at'],
                    'avatar' => $user['avatar']
                ]);
                
                header("Location: index.php");
                exit();
            } else {
                return [
                    'success' => false,
                    'message' => "Wrong Credentials. Please try again."
                ];
            }
        } else {
            return [
                'success' => false,
                'message' => "Email does not exist."
            ];
        }
    }

    // Get 
    public function get(int $page=1) {
        $sql = "SELECT * FROM users";
        $limit = 15;

        $data = Paginator::paginate($this->connect, $sql, $limit, $page);
        return $data;
    }

    // Search 
    public function search($search='') {
        $sql = "SELECT * FROM users WHERE name LIKE '%$search%'
                OR email LIKE '%$search%'
                OR phone LIKE '%$search%'
                OR shipping_address LIKE '%$search%'";

        try {
            $data = $this->connect->query($sql);
            return [
                'data' => $data
            ];
        } catch (Exception $err) {
            ThrowError::error($err);
        }
    }

    // Find 
    public function find($id) {
        try {
            $sql = "SELECT * FROM users WHERE id = '$id'";
            $data = $this->connect->query($sql);
            return $data;
        } catch (Exception $err) {
            ThrowError::error($err);
        }
    }

    // update user details 
    public function update($request, $files) {
        $user = Auth::user();           

        // store image 
        $avatar = isset($_FILES['image']) ? $this->UploadImage($files) : $user->avatar;

        $id = $user->id;
        $name = $request['name'];
        $email = $request['email'];
        $shippingAddress = $request['shipping_address'];

        $sql = "UPDATE users SET name='$name', email='$email', avatar='$avatar', shipping_address='$shippingAddress' WHERE id='$id'";

        try {
            $this->connect->query($sql);

            $user->update([
                'name' => $name,
                'email' => $email,
                'avatar' => $avatar,
                'shipping_address' => $shippingAddress
            ]);

            header("Location: profile.php?active-section=edit");
            // echo "<div class='success-alert'>Category created successful.</div>";
        } catch (Exception $err) {
            echo "<div class='err-exception-con'>$err</div>";
        }
    }

    // Delete 
    public function delete($request) {
        $id = $request['id'];

        $sql = "DELETE FROM users WHERE id='$id'";

        try {
            $this->connect->query($sql);
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        } catch (Exception $err) {
            echo "<div class='err-exception-con'>$err</div>";
        }
    }


    // update password
    public function updatePassword($request) {
        $id = Auth::user()->id;
        $oldPassword = $request['old_password'];
        $newPassword = $request['new_password'];

        $sql = "SELECT * FROM users WHERE id='$id'";
        $query = $this->connect->query($sql);

        if($query->num_rows > 0) {
            $user = $query->fetch_assoc();
            // return $user;
            if(password_verify($oldPassword, $user['password'])) {
                $password = password_hash($newPassword, PASSWORD_DEFAULT);
                $sql = "UPDATE users SET password='$password' WHERE id='$id'";
                $this->connect->query($sql);

                if(Auth::logout()) {
                    header("Location: login.php");
                    exit();
                };
            } else {
                return [
                  'success' => false,
                  'message' => "Wrong Credentials. Please try again."
                ];
            }
        }

    }


    // check email exist 
    public function checkEmailExist($email) {
        $sql = "SELECT * FROM users WHERE email='$email'";

        $data = $this->connect->query($sql);
        $check = $data->num_rows > 0 ? true : false; 
        return $check;
    }


    // upload image 
    private function UploadImage($files, $oldFile = null) {
        $image = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $check = getimagesize($files["image"]["tmp_name"]);
            if($check !== false) {
                $dir = 'images/user_images/';
                $fileUpload = new FileUpload($dir, $files['image'], $oldFile);
                $image = $fileUpload->upload();
            }
        }

        return $image;
    }

}