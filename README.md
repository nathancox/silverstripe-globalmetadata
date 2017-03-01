SilverStripe Global Metadata Module
===================================

This module lets you set a default MetaTitle and MetaDescription in site settings that can be overridden on individual pages.


Maintainer Contacts
-------------------
Nathan Cox (<nathan@room9.co.nz>)

Requirements
------------
* SilverStripe 3.2+

Documentation
-------------
[GitHub](https://github.com/room9/silverstripe-globalmetadata)

Installation Instructions
-------------------------

Unzip into a root folder called globalmetadata and run dev/build.

Coming soon: composer


Usage Overview
--------------

If MetaTitle is enabled it adds a field to every page.  Then the page's MetaTitle() is called (eg in a template) it will use the value of this field first.  If the field is empty it will fall back to the MetaTitle defined in Settings.  If that is empty it will use the page's Title.  If you're using $MetaTags in the template with show title enabled it will output the title tag using MetaTitle().  Otherwise it can be accessed in templates using $MetaTitle.

MetaData works the same way as MetaTitle.  If a page doesn't have a MetaDescription set then $MetaTags() will output a meta description element containing the default description from Settings.


Config options:

```yml
SiteConfig:
  show_meta_title: true					// turn on/off the meta title fields and behaviour
  show_meta_description: true			// turn on/off the meta description field and behaviour
  meta_title_description: ''			// set text that appears under the default meta title field
  meta_description_description: ''		// set text that appears under the default meta description field

Page:
  meta_title_description: ''			// set text that appears under the page meta title field
  meta_description_description: ''	    // set text that appears under the page meta description field
```


Issues
------------

Please [create an issue](http://github.com/room9/silverstripe-globalmetadata/issues) for any bugs you've found, or features you're missing.
