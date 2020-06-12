<!--
@author Christoph Böhringer
Klasse beinhaltet die Navbar für den Student und Befrager.
//-->

/**
 * @author Christoph Böhringer
 * Diese Klasse dient als Basis für die Oberfläche der Freischalten-Kurs Funktion.
 */
    
    <header>
        <nav>
            <ul>
                <li>
                <?php
                if(isset($_SESSION['befrager'])){
                    echo "<a href='menuBefrager.php'>Home</a>";
                }
                if (isset($_SESSION['matrikelnummer'])){
                    echo "<a href='MenuStudent.php'>Home</a>";
                }
            ?>
            </li>
                <li><a href="index.php">Logout</a></li>
                <a class="text">Befragungstool der DHBW Ravensburg</a>
            </ul>
        </nav>
    </header>
