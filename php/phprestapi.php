<?php
require_once "koneksi.php";

if (function_exists($_GET['function'])) {
    $_GET['function']();
}

function get_notes()
{
    global $connect;
    $query = $connect->query("SELECT * FROM note ORDER BY date DESC, id DESC");

    while ($row = mysqli_fetch_object($query)) {
        $data[] = $row;
    }

    $response = array(
        'status' => 1,
        'message' => 'Success',
        'data' => $data
    );

    header('Content_Type: application/json');
    echo json_encode($response);
}

function get_note_id()
{
    global $connect;

    if (!empty($_GET["id"])) {
        $id = $_GET["id"];
    }

    $query = "SELECT * FROM note WHERE id = $id";
    $result = $connect->query($query);

    while ($row = mysqli_fetch_object($result)) {
        $data[] = $row;
    }

    if ($data) {
        $response = array(
            'status' => 1,
            'message' => 'Success',
            'data' => $data
        );
    } else {
        $response = array(
            'status' => 0,
            'message' => 'No Data Found'
        );
    }

    header('Content_Type: application/json');
    echo json_encode($response);
}

function insert_note()
{
    global $connect;

    $check = array(
        'message' => '',
        'date' => ''
    );
    $check_match = count(array_intersect_key($_POST, $check));

    if ($check_match == count($check)) {
        $result = mysqli_query($connect, "INSERT INTO note SET 
        message = '$_POST[message]',
        date = '$_POST[date]'");

        if ($result) {
            $response = array(
                'status' => 1,
                'message' => 'Insert Success'
            );
        } else {
            $response = array(
                'status' => 0,
                'message' => 'Insert Failed'
            );
        }
    } else {
        $response = array(
            'status' => 0,
            'message' => 'Wrong Parameter'
        );
    }

    header('Content_Type: application/json');
    echo json_encode($response);
}

function update_note()
{
    global $connect;

    if (!empty($_GET["id"])) {
        $id = $_GET["id"];
    }

    $check = array(
        'message' => '',
        'date' => ''
    );
    $check_match = count(array_intersect_key($_POST, $check));

    if ($check_match == count($check)) {
        $result = mysqli_query($connect, "UPDATE note SET
        message = '$_POST[message]',
        date = '$_POST[date]' WHERE id = $id");

        if ($result) {
            $response = array(
                'status' => 1,
                'message' => 'Update Success'
            );
        } else {
            $response = array(
                'status' => 0,
                'message' => 'Update Failed'
            );
        }
    } else {
        $response = array(
            'status' => 0,
            'message' => 'Update Failed',
            'data' => $id
        );
    }

    header('Content_Type: application/json');
    echo json_encode($response);
}

function delete_note()
{
    global $connect;
    $id = $_GET['id'];
    $query = "DELETE FROM note WHERE id =".$id;

    if (mysqli_query($connect, $query)) {
        $response = array(
            'status' => 1,
            'message' => 'Delete Success'
        );
    } else {
        $response = array(
            'status' => 0,
            'message' => 'Delete Fail'
        );
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}

function get_users()
{
    global $connect;
    $query = $connect->query("SELECT * FROM users");

    while ($row = mysqli_fetch_object($query)) {
        $data[] = $row;
    }

    $response = array(
        'status' => 1,
        'message' => 'Success',
        'data' => $data
    );

    header('Content_Type: application/json');
    echo json_encode($response);
}

function get_user_login()
{
    global $connect;

    if (!empty($_GET["username"]) && !empty($_GET["password"])) {
        $username = $_GET["username"];
        $password = $_GET["password"];
    }

    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password' ";
    $result = $connect->query($query);

    while ($row = mysqli_fetch_object($result)) {
        $data[] = $row;
    }

    if ($data) {
        $response = array(
            'status' => 1,
            'message' => 'Login Success',
            'data' => $data
        );
    } else {
        $response = array(
            'status' => 0,
            'message' => 'Login Failed'
        );
    }

    header('Content_Type: application/json');
    echo json_encode($response);
}

function insert_user()
{
    global $connect;

    $check1 = array(
        'username' => '',
        'password' => '',
        'profileImage' => ''
    );

    $check2 = array(
        'username' => '',
        'password' => ''
    );

    $check_match1 = count(array_intersect_key($_POST, $check1));
    $check_match2 = count(array_intersect_key($_POST, $check2));

    if ($check_match1 == count($check1)) {
            $result = mysqli_query($connect, "INSERT INTO users SET 
            username = '$_POST[username]',
            password = '$_POST[password]',
            profileImage = '$_POST[profileImage]'");

        if ($result) {
            $response = array(
                'status' => 1,
                'message' => 'Insert Success'
            );
        } else {
            $response = array(
                'status' => 0,
                'message' => 'Insert Failed'
            );
        }
    } else if ($check_match2 == count($check2)){
        $result = mysqli_query($connect, "INSERT INTO users SET 
        username = '$_POST[username]',
        password = '$_POST[password]'");

        if ($result) {
            $response = array(
                'status' => 1,
                'message' => 'Insert Success'
            );
        } else {
            $response = array(
                'status' => 0,
                'message' => 'Insert Failed'
            );
        }
    } else {
        $response = array(
            'status' => 0,
            'message' => 'Wrong Parameter'
        );
    }

    header('Content_Type: application/json');
    echo json_encode($response);
}

function update_user()
{
    global $connect;

    if (!empty($_GET["id"])) {
        $id = $_GET["id"];
    }

    $check1 = array(
        'username' => '',
        'password' => '',
        'profileImage' => ''
    );

    $check2 = array(
        'username' => '',
        'password' => ''
    );

    $check_match1 = count(array_intersect_key($_POST, $check1));
    $check_match2 = count(array_intersect_key($_POST, $check2));

    if ($check_match1 == count($check1)) {
            $result = mysqli_query($connect, "UPDATE users SET 
            username = '$_POST[username]',
            password = '$_POST[password]',
            profileImage = '$_POST[profileImage]' WHERE id = $id");

        if ($result) {
            $response = array(
                'status' => 1,
                'message' => 'Update Success'
            );
        } else {
            $response = array(
                'status' => 0,
                'message' => 'Update Failed'
            );
        }
    } else if ($check_match2 == count($check2)){
        $result = mysqli_query($connect, "UPDATE users SET 
        username = '$_POST[username]',
        password = '$_POST[password]' WHERE id = $id");

        if ($result) {
            $response = array(
                'status' => 1,
                'message' => 'Update Success'
            );
        } else {
            $response = array(
                'status' => 0,
                'message' => 'Update Failed'
            );
        }
    } else {
        $response = array(
            'status' => 0,
            'message' => 'Wrong Parameter'
        );
    }

    header('Content_Type: application/json');
    echo json_encode($response);
}

function delete_user()
{
    global $connect;
    $id = $_GET['id'];
    $query = "DELETE FROM users WHERE id =".$id;

    if (mysqli_query($connect, $query)) {
        $response = array(
            'status' => 1,
            'message' => 'Delete Success'
        );
    } else {
        $response = array(
            'status' => 0,
            'message' => 'Delete Fail'
        );
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}

function upload_image()
{
    $image = $_FILES[$_POST['profileImage']]['tmp_name'];
    $imageName = $_FILES[$_POST['profileImage']]['name'];
    
    $file_path = $_SERVER['DOCUMENT_ROOT'].'/notesapi/images';
    
    if (!file_exists($file_path)) {
        mkdir($file_path, 0777, true);
    }

    if(move_uploaded_file($image, $file_path.'/'.$imageName)){
        return "Sukses Upload Gambar";
    }
}

function upload()
{
    // $image = $_FILES[$_POST['imageName']]['tmp_name'];
    // $imagename = $_FILES[$_POST['imageName']]['name'];

    $image = $_FILES['file']['tmp_name'];
    $imagename = $_FILES['file']['name'];
    
    $file_path = $_SERVER['DOCUMENT_ROOT'] . '/notesapi/images';
    
    if (!file_exists($file_path)) {
        mkdir($file_path, 0777, true);
    }
    
    if(!$image){
            $data = array(
                'status' => 0,
                'message' => "Gambar tidak ditemukan");
    }
    else{
        if(move_uploaded_file($image, $file_path.'/'.$imagename)){
            $data = array(
                'status' => 1,
                'message' => "Sukses Upload Gambar");
        }
    }

    header('Content_Type: application/json');
    echo json_encode($data);
}