<div class="header">
    <span><?php p($project->getName());?></span>

</div>

<div id="editmenu"></div>
<div class="navigation">
    <a class="index" href="?"><img src="app/webroot/assets/img/back.svg" /></a>
    <span class="share_project">
        <?php if($project->isShared()) {?>

            <a class="publicUrl" href="?<?php p(sprintf('v=projects&a=readonly&name=%s&key=%s', $project->getName(), $project->getSharekey())); ?>">
                share this url
            </a>
            <a href="#" id="unshareProject">unshare</a>
        <?php } else { ?>
            <a href="#" id="shareProject">Generate shareable link</a>
        <?php } ?>
    </span>


</div>

<progress id="uploadprogress" min="0" max="100" value="0" >0</progress>
<div id="project" class="pcontent">
    <article>
        <div id="holder">
            <input id="pup" class="knob" data-width="100" data-angleOffset="0" data-fgColor="#81DCDD" data-bgColor="#FFFFFF" data-thickness=".05" value="0">
        </div>
        <p id="upload" class="hidden">
            <span class="cameraupload"></span>
            <input id="uup" class="upload" type="file"/>
        </p>
        <p id="filereader"></p>
        <p id="formdata"></p>
        <p id="progress"></p>
    </article>

    <div class="activeProject"><?php p($project->getName());?></div>

    <div id="newMarkdown" class="row">
        <div class="c3 edit-mode">
            <p class="date">preview</p>
            <div class="ncontent"><div class="content"><div class="markdown-body"></div></div></div>
        </div>
        <div class="c3edit" style="display:inline-block;">
            <textarea id="addfield" class="editareafield" placeholder="start writing markdown here" ></textarea>
            <a class="addPost" href="#"></a>
            <a class="discardAdd" href="#"></a>
            <a class="backup" href="#"></a>
        </div>
    </div>

    <?php foreach($nodes as $node) { ?>

        <div class="row node-<?php p($node->type);?>" data-name="<?php p($node->getName());?>">
            <div class="snap-drawers">
                <div class="snap-drawer snap-drawer-right">
                    <a class="edit m-sub e" href="#"></a>
                    <a class="delete m-sub d" href="#"></a>
                </div>
            </div>
            <div class="snap-content c3">
                <p class="date">
                    <?php p(date(Config\Config::DATE_FORMAT, $node->getTimestamp()));?>
                </p>
                <div class="ncontent">
                    <?php if( get_class($node) === 'Models\NodeTexts' ) {?>
                        <div class="content">
                            <div class="markdown-body"><?php p($node->getContent());?></div>
                        </div>
                    <?php } else if ( get_class($node) === 'Models\NodeImages' ) {?>
                        <a href="<?php p($node->getOriginalPath());?>">
                            <img src="<?php p($node->getPath());?>"/>
                        </a>
                    <?php } ?>

                    <div class="actions">
                        <?php if( $node->editable ) { ?>
                            <a class="edit-big" href="#" data-target="r"></a>
                        <?php } ?>
                        <a class="download-big" href="#"></a>
                        <a class="delete-big" href="#"></a>
                    </div>
                </div>
            </div>
            <?php if( $node->editable ) { ?>
                <div class="c3edit">
                    <textarea class="editareafield"></textarea>
                    <a href="#" class="save"></a>
                    <a href="#" class="discardUpdate"></a>
                    <a href="#" class="backup"></a>
                </div>
            <?php } ?>
        </div>

    <?php } ?>
</div>
