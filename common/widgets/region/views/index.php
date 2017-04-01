<?php
?>
<div id="content-wrap">     
            <div id="content-left" class="demo">

            		<?php if(!empty($data)):?>
                        <div class="infolist">
                            <lable>所在地区：</lable>
                            <div class="liststyle">
                                <span id="Province">
                                    <i></i>
                                    <ul>
                                        <li><a href="javascript:void(0)" alt="<?=$data['province']?>"><?=$data['province']?></a></li>
                                    </ul>
                                    <input type="hidden" name="cho_Province" value="<?=$data['province']?>">
                                </span>
                                <span id="City">
                                    <i><?=$data['city']?></i>
                                    <ul>
                                        <li><a href="javascript:void(0)" alt="<?=$data['city']?>"><?=$data['city']?></a></li>
                                    </ul>
                                    <input type="hidden" name="cho_City" value="<?=$data['city']?>">
                                </span>
                                <span id="Area">
                                    <i><?=$data['area']?></i>
                                    <ul>
                                        <li><a href="javascript:void(0)" alt="<?=$data['area']?>"><?=$data['area']?></a></li>
                                    </ul>
                                    <input type="hidden" name="cho_Area" value="<?=$data['area']?>">
                                </span>
                            </div>
                        </div>
                    <?php endif;?>

            </div>
            <div id="content-right"></div>
        </div>