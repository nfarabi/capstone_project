<?php

namespace App\Helpers;

use App\Language;
use App\Page;

class Copy
{
    /**
     * Copy Language model.
     *
     * @param Language $language
     * @return mixed
     */
    public static function language( Language $language )
    {
        // Replicate the old model
        $new = $language->replicate();

        $new->label = 'Copy of ' . $new->label;
        $new->code = 'copy-of-' . $new->code;

        // Set to inactive
        $new->activate( false );

        // Save the new model
        $new->save();

        return $new;
    }

    /**
     * Copy Page model.
     *
     * @param Page $page
     * @return mixed
     */
    public static function page( Page $page )
    {
        // Replicate the old model
        $new = $page->replicate();

        // Change the slug to NULL to generate new slug
        $new->slug = null;

        // Set to unpublished, not featured & not homepage by default
        $new->feature( false );
        $new->homepage( false );
        $new->publish( false );

        // Save the new model
        $new->save();

        return $new;
    }
}
