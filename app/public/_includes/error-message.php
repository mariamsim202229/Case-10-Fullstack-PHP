<?php 
        if (isset($_SESSION["error_message"])) {
            echo "<b>" . $_SESSION["error_message"] . "</b>";
        }

        // reset error message
        unset($_SESSION["error_message"]);
?>