<?php
    include_once(__DIR__ . "/../bootstrap.php");
    include_once(__DIR__ . "/../classes/Db.php");
    include_once(__DIR__ . "/../classes/Review.php");
    include_once(__DIR__ . "/../classes/User.php");
    
    use Hatice\makeupshop\User;
    use Hatice\makeupshop\Review;

    session_start();
    if(!empty($_POST)){
        //new review

        // if (!isset($_SESSION['email'])) {
        //     echo json_encode(['status' => 'error', 'message' => 'User not logged in.']);
        // }
        $user = User::getByEmail($_SESSION["email"]);
        $userId = $user['id'];

        // if (!$user) {
        //     echo json_encode(['status' => 'error', 'message' => 'User not found.']);
        //     exit;
        // }
        $review = new Review();
        $review->setProduct_id($_POST['product_id']);
        $review->setText($_POST['text']);
        $review->setUser_id($userId);
        //save
        $review->saveReview();
        //success
        $response = [
            'status' => 'success',
            'body' => htmlspecialchars($review->getText()),
            'message' => 'Review saved'
        ];

        header('Content-Type: application/json');
        echo json_encode($response); 
    }

?>