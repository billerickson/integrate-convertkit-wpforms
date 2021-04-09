# Integrate ConvertKit and WPForms

**Contributors:** billerickson  
**Donate link:** https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=ZHXHYVWJCTZ94  
**Tags:** form, wpforms, convertkit, email, marketing  
**Requires at least:** 3.0.1  
**Tested up to:** 5.7  
**Stable tag:** 1.3.0  
**License:** GPLv2 or later  
**License URI:** http://www.gnu.org/licenses/gpl-2.0.html  

Create ConvertKit signup forms using WPForms

## Description

"Integrate ConvertKit and WPForms" easily connects forms on your website to your [ConvertKit](http://mbsy.co/convertkit/28981746) email marketing account, enabling you to capture more leads and manage campaigns more effectively.

[WPForms](http://www.shareasale.com/r.cfm?u=402581&b=834775&m=64312&afftrack=convertkit%2Dplugin&urllink=)' simple drag-and-drop form builder allows you to create new forms with ease and its clean, modern code makes customizations a snap. This integration also works with the free version, [WPForms Lite](https://wordpress.org/plugins/wpforms-lite/), but I highly recommend purchasing the full WPForms for the valuable premium features and support.

Please support the development of this free plugin by using the affiliate links above.

If you are having issues with ConvertKit not receiving your submissions, you can enable logging and share that data with ConvertKit support. Go to WPForms > Tools > Logs, check "Enable logging", and enable it for "Providers". Once enabled, any form submission that is processed by this plugin will also store the ConvertKit API response in WPForms > Tools > Logs.

I recommend that you only enable logging for as long as necessary to debug your issue, then disable logging so you don't fill up the database with unnecessary logs.

## Installation

 1. Install this plugin, along with [WPForms](http://www.shareasale.com/r.cfm?u=402581&b=834775&m=64312&afftrack=convertkit%2Dplugin&urllink=) (or [WPForms Lite](https://wordpress.org/plugins/wpforms-lite/)).
 2. In the WordPress Dashboard, go to WPForms > Add New and create a form. You can add whatever fields you like, but at a minimum you must include an Email and Name field. (See screenshot 1)
 3. Click “Settings” in the left column, then select “ConvertKit”. From the two dropdowns, select the Name and Email fields you created. (See screenshot 2)
 4. In a separate browser tab, go to ConvertKit, log in, and click [Account](https://app.convertkit.com/account/edit). Copy the API Key, go back to the WPForms ConvertKit settings page, and paste it in the field titled “ConvertKit API Key”.
 5. Back on the ConvertKit site, click “Forms” then select the form you want to use (or create a new one). When editing the form, look at the URL. It should be something like https://app.convertkit.com/landing_pages/12345/edit. The number after “landing_pages/” and before “/edit”  is your Form ID. Copy this number, go back to WPForms ConvertKit settings page, and paste it in the field titled “Form ID”.
 6. Click “Save” in the top right corner, and exit out of the form builder.
 7. Insert the form somewhere on your site and test it out! Go to Pages, select a page, and above the content editor click “Add Form”. Select your form and click “Insert” to add it to the page.

## Screenshots

![Form Creation](https://www.billerickson.net/wp-content/uploads/2017/04/wpforms-convertkit-1.png)
Creating a form with a Name and Email field.

![Form Settings](https://www.billerickson.net/wp-content/uploads/2017/04/wpforms-convertkit-2.png)
ConvertKit Settings panel while editing form.

## Changelog
See [CHANGELOG.md](https://github.com/billerickson/integrate-convertkit-wpforms/blob/master/CHANGELOG.md)
