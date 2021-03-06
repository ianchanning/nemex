<div class="header">
    <span><?php p($project->getName());?></span>
</div>

<progress id="uploadprogress" min="0" max="100" value="0" >0</progress>
<div id="project" class="pcontent">

    <div class="activeProject"><?php p($project->getName());?></div>

    <?php foreach($nodes as $node) { ?>
        <div class="row node-<?php p($node->type);?>" data-name="<?php p($node->getName());?>">
            <div class="snap-content c3">
                <p class="date">
                    <?php p(date(Config\Config::DATE_FORMAT, $node->getTimestamp()));?>
                </p>
                <div class="ncontent">
                    <?php if( $node instanceof Models\NodeTexts ) {?>
                        <div class="content">
                            <div class="markdown-body"><?php p($node->getContent());?></div>
                        </div>
                    <?php } else if ( $node instanceof Models\NodeImages ) {?>
                        <a href="<?php p($node->getOriginalPath());?>">
                            <img src="<?php p($node->getPath());?>"/>
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>

    <?php } ?>
</div>
