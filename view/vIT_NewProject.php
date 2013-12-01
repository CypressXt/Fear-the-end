<?php include_once 'view/vIT_Menu.php'; ?>
<script>
    tinymce.init({selector: 'textarea.mce'});
</script>
<form class="tableNewProject center" method="post" action="newProject.fte" enctype="multipart/form-data">
    <table>
        <tr>
            <td class="left">
                <label for="title">Project Title</label>
            </td>
            <td class="right">
                <input id="title" type="text" name="title" value="" />
            </td>
        </tr>
        <tr><td class="emptyTd" colspan="2"></td></tr>
        <tr>
            <td class="left">
                <label for="tags">Project tags</label>
            </td>
            <td class="right">
                <input id="tag" type="text" name="tags"/>
                <script>
                    $('#tag').magicSuggest({
                        id: 'tag',
                        name: 'tags',
                        data: '<?php echo $tagsList; ?>',
                        hideTrigger : true,
                        allowFreeEntries: false
                    });
                </script>
            </td>
        </tr>
        <tr><td class="emptyTd" colspan="2"></td></tr>
        <tr>
            <td class="left">
                <label>Project Banner (1200 x 400px)</label>
            </td>
            <td>
                <input type="file" id="bannFile" name="bannFile">
            </td>
        </tr>
        <tr><td class="emptyTd" colspan="2"></td></tr>
        <tr>
            <td class="left">
                <label>Project picture</label>
            </td>
            <td>
                <input type="file" name="pictFile">
            </td>
        </tr>
        <tr><td class="emptyTd" colspan="2"></td></tr>
        <tr>
            <td class="left">
                <label for="description">Short project description</label>
            </td>
            <td>
                <textarea id="description" placeholder="Max 500 char" name="description"></textarea>
            </td>
        </tr>
        <tr><td class="emptyTd" colspan="2"></td></tr>
        <tr>
            <td class="left">
                <label for="introduction">Project introduction</label>
            </td>
            <td>
                <textarea id="introduction" name="introduction"></textarea>
            </td>
        </tr>
        <tr><td class="emptyTd" colspan="2"></td></tr>
        <tr>
            <td class="left">
                <label for="content">Project content</label>
            </td>
            <td>
                <textarea class="mce" id="content" name="content"></textarea>
            </td>
        </tr>
        <tr><td class="emptyTd" colspan="2"></td></tr>
        <tr>
            <td class="left">
            </td>
            <td>
                <input type="submit" name="publish" class="btn center blue" value="Créer">
            </td>
        </tr>
    </table>
</form>
</div>
</body>
</html>