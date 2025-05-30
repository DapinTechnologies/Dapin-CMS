<?php

namespace App\Helpers;



    if (!function_exists('panel')) {
        function panel($slug)
        {
            return \App\Models\Field::field($slug);
        }

}
