<?php

/**
 *
 * @TODO pick a config scheme.  Setting config on "GlobalMetaData" would be nice but require an extra
 *      object to store the config. Otherwise we set/fetch config values on SiteConfig or use
 *      something ugly like "GlobalMetadataConfigExtension" and
 *      Config::inst()->get('GlobalMetadataConfigExtension', 'show_meta_title')
 *
 * @package globalmetadata
 */
class GlobalMetadataConfigExtension extends DataExtension
{

    public static $db = array(
        'MetaTitle' => 'Varchar(200)',
        'MetaDescription' => 'Text'
    );

    private static $show_meta_title = true;
    private static $show_meta_description = true;

    private static $meta_title_description = '';
    private static $meta_description_description = '';

    public function updateCMSFields(FieldList $fields)
    {
        $fields->addFieldToTab('Root.Metatags', LiteralField::create('Explanation', '<p>'._t(
            'GlobalMetaData.DefaultExplanation',
            'These default values can be overwritten on individual pages.'
        ).'</p>'));


        if (SiteConfig::config()->show_meta_title) {
            $fields->addFieldToTab('Root.Metatags', $metaTitleField = TextField::create('MetaTitle', _t(
                'GlobalMetaData.MetaTitleLabel',
                'Page title'
            )));
            if (SiteConfig::config()->meta_title_description) {
                $metaTitleField->setDescription(SiteConfig::config()->meta_title_description);
            }
        }

        if (SiteConfig::config()->show_meta_description) {
            $fields->addFieldToTab('Root.Metatags', $metaDescriptionField = TextareaField::create('MetaDescription', _t(
                'GlobalMetaData.MetaDescriptionLabel',
                'Meta description'
            )));
            if (SiteConfig::config()->meta_description_description) {
                $metaDescriptionField->setDescription(SiteConfig::config()->meta_description_description);
            }
        }
    }

    /**
     * Return the default meta title, or blank if meta title is hidden
     * @return string
     */
    public function getDefaultMetaTitle()
    {
        return SiteConfig::config()->show_meta_title ? $this->owner->MetaTitle : '';
    }

    /**
     * Return the default meta description, or blank if meta description is hidden
     * @return string
     */
    public function getDefaultMetaDescription()
    {
        return SiteConfig::config()->show_meta_description ? $this->owner->MetaDescription : '';
    }
}
