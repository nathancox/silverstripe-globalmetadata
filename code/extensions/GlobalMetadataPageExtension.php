<?php

/**
 *
 * @package globalmetadata
 */
class GlobalMetadataPageExtension extends DataExtension
{

    public static $db = array(
        'MetaTitle' => 'Varchar(200)'
    );

    private static $meta_title_description = 'This will replace the title tag';
    private static $meta_description_description = '';


    public function updateCMSFields(FieldList $fields)
    {
        $config = SiteConfig::current_site_config();
        if (SiteConfig::config()->show_meta_title) {
            $fields->insertBefore('MetaDescription', $metaTitleField = TextField::create('MetaTitle', _t(
                'GlobalMetaData.MetaTitleLabel',
                'Page title'
            )));
            $metaTitleField->setAttribute('placeholder', $config->getDefaultMetaTitle());
            if (Page::config()->meta_title_description) {
                $metaTitleField->setDescription(Page::config()->meta_title_description);
            }
        }

        $metaDescriptionField = $fields->dataFieldByName('MetaDescription');
        if ($config->getDefaultMetaDescription()) {
            $metaDescriptionField->setAttribute('placeholder', $config->getDefaultMetaDescription());
        }
        if (Page::config()->meta_description_description) {
            $metaDescriptionField->setDescription(Page::config()->meta_description_description);
        }
    }

    public function MetaTags(&$tags)
    {
        // if a <title> tag exists replace it with the MetaTitle or
        $newTitle = $this->owner->MetaTitle();

        if ($newTitle) {
            $titleRegex = '/(?<=\<title\>)(.*?)(?=\<\/title\>)/';
            $tags = preg_replace($titleRegex, $newTitle, $tags);
        }

        // If the page has a MetaDescription, it will already have had a tag added so
        // if the page has no MetaDescription then we can add a default description tag.
        if (!$this->owner->MetaDescription && $this->owner->MetaDescription()) {
            $tags .= "<meta name=\"description\" content=\"" . Convert::raw2att($this->owner->MetaDescription()) . "\" />\n";
        }
    }



    /**
     * Get the page's final MetaTitle, falling back through Page::MetaTitle > SiteConfig::MetaTitle > Page::Title
     * @return string
     */
    public function MetaTitle()
    {
        $config = SiteConfig::current_site_config();

        if ($this->owner->MetaTitle) {
            $title = $this->owner->MetaTitle;
        } elseif ($config->getDefaultMetaTitle()) {
             $title = $config->getDefaultMetaTitle();
        } else {
            $title = $this->owner->Title;
        }

        return $title;
    }

    /**
     * Get the page's final MetaDescription, falling back from Page::MetaDescription to SiteConfig::MetaDescription
     * @return string
     */
    public function MetaDescription()
    {
        $config = SiteConfig::current_site_config();

        if ($this->owner->MetaDescription) {
            $description = $this->owner->MetaDescription;
        } elseif ($config->getDefaultMetaDescription()) {
             $description = $config->getDefaultMetaDescription();
        } else {
            $description = '';
        }

        return $description;
    }
}
