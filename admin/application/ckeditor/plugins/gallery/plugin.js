/*
Copyright (c) 2003-2010, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

/**
 * @file Gallery Plugin
 */

CKEDITOR.plugins.add( 'gallery',
{
	init : function( editor )
	{
		var pluginName = 'gallery';

		// Register the command.
		var command = editor.addCommand( pluginName, CKEDITOR.plugins.gallery );

		// Register the toolbar button.
		editor.ui.addButton( 'Gallery',
			{
				label : 'Add Gallery',
				command : pluginName,
                                icon: this.path + 'images/gallery_icon.jpg'
			});
	}
} );

CKEDITOR.plugins.gallery =
{
	exec : function( editor )
	{
		//alert("Galerije BOX");
                //senadInsertElement();
                //console.log(editor);
                //editor.insertHtml('<span>&nbsp;</span>');
                //console.log(editor.customData.myJq);
                $("#gallery-dialog").dialog('open');
                
	}
};


