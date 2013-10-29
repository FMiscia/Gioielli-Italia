 /**
 * Get IMAGE files recursively from Root and all sub-folders
 * Skip folders in our list of results
 * LEAVES_ONLY mode makes sure ONLY FILES/Leafs endpoint is returned
 * Make sure file extension is in our Images extensions array
 */
<?php


	$dirs = array_filter(glob('assets/img/Immagini/*'), 'is_dir');       
        foreach ($dirs as $dir) {
            $dirname = "assets/img/Immagini/$dir";
            $images = \glob($dirname . "/*.{jpg,png,JPG}", \GLOB_BRACE);
            foreach ($images as $image) {
                echo $dir.' : '.$image;
            }
        }


?>

