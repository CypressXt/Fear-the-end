<?php include_once 'view/vIT_Menu.php'; ?>
<div class="projectContener">
    <div class="projectBanner">
        <img src="<?php echo $projectShowed->getBanner(); ?>"/>
        <h1><?php echo ucfirst($projectShowed->getTitle()); ?></h1>
    </div>
    <div class="projectNav">
        <ul>
            <a href="/project/<?php echo $projectShowed->getId();?>">Home</a>
            <a href="#">Worklog</a>
            <a href="#">Media</a>
            <a href="/project/<?php echo $projectShowed->getId();?>/team">Team</a>
            <a href="#">About</a>
        </ul>
        <div class="projectSpecs">
            Created: <?php echo $dateFormated; ?> | Instigator: <?php echo ucfirst($autName); ?> | 
            Tags: <?php
            foreach ($projectShowed->getTag() as $tag) {
                echo " #";
                echo '<a href="/projectByTag/'.$tag[0].'">'.$tag[0]."<a/>";
            }
            ?>
        </div>
    </div>
    <div class="projectDescription">
        <p><?php echo $description; ?></p>
    </div>
    <div class="projectIntroduction">
        <p><?php echo $introduction; ?></p>
    </div>
    <div class="projectContent">
        <?php echo $content; ?>
    </div>
</div>
</body>
</html>