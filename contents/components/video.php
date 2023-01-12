<?php
// this function is used to create video elements across the app.
function renderVideo($videoPath)
{
    $video = "<video style='
                object-fit: fill;
                border-radius: 1rem;
                width: 100%;
                height: auto;
                ' autoplay muted loop>
                    <source src='{$videoPath}' />
                    Your browser does not support the video tag.
            </video>";
    return $video;
}
