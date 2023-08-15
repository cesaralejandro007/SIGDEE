<div class="col-12">
    <img style="border: 1px solid gray;width: 100%;height:30%; margin-top:5px;" id="captcha"
        src="<?php echo "vista/componentes/securimage/securimage_show.php"; ?>" alt="CAPTCHA Image" />

    <div id="captcha_image_audio_div">
        <audio id="captcha_image_audio" preload="none" style="display: none">
            <source id="captcha_image_source_wav"
                src="<?php echo "vista/componentes/securimage/"; ?>securimage_play.php?id=1234" type="audio/wav">
            <object type="application/x-shockwave-flash"
                data="securimage_play.swf?bgcol=%23ffffff&amp;icon_file=images%2Faudio_icon.png&amp;audio_file=securimage_play.php"
                height="32" width="32">
                <param name="movie"
                    value="securimage_play.swf?bgcol=%23ffffff&amp;icon_file=images%2Faudio_icon.png&amp;audio_file=securimage_play.php" />
            </object>
        </audio>
    </div>

    <div class="d-flex" id="captcha_image_audio_controls" class="row">
        <a tabindex="-1" class="captcha_play_button" style="margin-top: 5px;margin-right: 5px;margin-left: 10px; "
            href="<?php echo "vista/componentes/securimage/"; ?>securimage_play.php?id=1234 ?>"
            onclick="return false">
            <img class="captcha_play_image" height="32" width="32"
                src="<?php echo "vista/componentes/securimage/"; ?>images/audio_icon.png" alt="Play CAPTCHA Audio"
                style="border: 0px">
            <img class="captcha_loading_image rotating" height="33" width="33"
                src="<?php echo "vista/componentes/securimage/"; ?>images/loading.png" alt="Loading audio"
                style="display: none">
        </a>

        <noscript>Habilitar Javascript para controles de audio</noscript>

        <a tabindex="-1" href="javascript:void(0)" style="margin-right: 15px;"
            onclick="document.getElementById('captcha').src = '<?php echo "vista/componentes/securimage/"; ?>securimage_show.php?' + Math.random(); captcha_image_audioObj.refresh(); this.blur(); return false">

            <img height="32" width="32" src="<?php echo "vista/componentes/securimage/"; ?>images/refresh.png"
                alt="Refresh Image" onclick="this.blur()" style="border: 0px; margin-top: 5px;" />
        </a>
        <input type="text" name="captcha" id="captcha_code" class="form-control " placeholder="Codigo de Seguridad"
            style="width: 70%;margin-top: 5px;">
        

    </div>

    <script type="text/javascript" src="<?php echo "vista/componentes/securimage/"; ?>securimage.js"></script>
    <script type="text/javascript">
    captcha_image_audioObj = new SecurimageAudio({
        audioElement: 'captcha_image_audio',
        controlsElement: 'captcha_image_audio_controls'
    });
    </script>

    <div style="clear: both"></div>
</div>