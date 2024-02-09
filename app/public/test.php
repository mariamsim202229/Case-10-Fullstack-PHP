if ($_SERVER["REQUEST_METHOD"] == "POST" ) {
    $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
    if (isset($_POST['delete'])) {
        $pageDelete = $page->delete_one($id);
        header('Location: page.php');
    }
}

    if ($_SERVER["REQUEST_METHOD"] == "POST"  ) {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $title = isset($_GET['title']) ? $_GET['title'] : '';
        $content = isset($_GET['content']) ? $_GET['content'] : '';
    
        $user_id = $_SESSION['user_id'];
        $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
        $title = isset($_POST['title']) ? trim($_POST['title']) : "";
        $content = isset($_POST['content']) ? trim($_POST['content']) : "";

    if (isset($_POST['update'])) {
        $pageUpdate = $page->edit_page($title, $content);
        header('Location: page.php?id= ' . $id . '');
    }

    print_r2($pageUpdate);
}