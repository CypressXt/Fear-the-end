<?php include_once 'view/vIT_Menu.php'; ?>
    <table class="projectTable">
        <tr>
            <td>
                <div class="projectColumn" id="projectColumn1">
                    <?php
                    foreach ($colonne1HTML as $value) {
                        echo $value;
                    }
                    ?>
                </div>                    
            </td>
            <td>
                <div class="projectColumn" id="projectColumn2">
                    <?php
                    foreach ($colonne2HTML as $value) {
                        echo $value;
                    }
                    ?>
                </div>
            </td>
            <td>
                <div class="projectColumn" id="projectColumn3">
                    <?php
                    foreach ($colonne3HTML as $value) {
                        echo $value;
                    }
                    ?>
                </div>
            </td>
        </tr>
    </table>
</div>
</body>
</html>