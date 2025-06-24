
<?php
    function get_cats() { //DO ADMINKY
        include "db.php";
        $sql = "SELECT * FROM kategorie";
        $query = mysqli_query($conn, $sql);
        $html = "";
        if($query) {
            $i = 0;
            while($row = mysqli_fetch_assoc($query)) {
                $html .= '<input id="cat'.$i.'" class="category-section-radio" type="radio" name="category" value="'.$row["id"].'">'
                    .'<label for="cat'.$i.'" class="category-section-label">'.$row["kategoria"].'</label>';
                $i++;
            }
        }
        return $html;
    }
    if(isset($_GET["option"])) {
        if($_GET["option"] === "load") echo load_cats();
    }
    function load_cats() { //DO ETERU
        return $ht;
        include "db.php";
        $sql = "SELECT * FROM kategorie";
        $query = mysqli_query($conn, $sql);
        $ht = "";
        if($query) {
            while($row = mysqli_fetch_assoc($query)) {
            $ht .= '<a class="navitem" href="category.php?id='.$row["id"].'">'
                .'<div class="navitemoverlay"></div>'
                .'<div class="navitemtext">'.$row["kategoria"].'</div>'
                .'</a>'; 
            }
        }
        return $ht;
    }
?>